<?php
	session_start();
	include "../../secure.php";

	include "../../../../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
	$banyakindex = 3;

	function rupiah($angka){
	
		$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
		return $hasil_rupiah;
	 
	}
				
	if(isset($_POST['start']) && @$_POST['start'] >= 0){
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
		$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("ss",$username,$password);
		$exquery->execute();
		$tanggal = date("Y-m-d H:i:s");
		if($exquery){
			$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

			$iduser = $tampil[0]["Id"];
		}

		$start = $_POST['start'];		
		$query = "SELECT * FROM `cart` WHERE usermanagerid = $iduser AND status='belumbayar'";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$result = $exquery->execute();
		if($result){
			$html = "";
			$totalbayar = 0;
			$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
			for($i=0;$i<count($hasil);$i++){
				$item_id = $hasil[$i]['itemid'];
				$query2 = "SELECT * FROM `produk` WHERE id = $item_id";
				$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
				if($exquery2){
					$hasil2 = mysqli_fetch_array($exquery2);

					$html .= "<tr>
						<td style=\"font-size: large; font-weight: bold;width: 60%;\">".$hasil2['nama']."<br>
						<a href='../images/".$hasil2['imageurl']."'  onclick='return hs.expand(this)' class='highslide'><img src='../images/".$hasil2['imageurl']."' width=120px height=120px ></a><br>
							".rupiah($hasil2['harga'])."
						</td>
						<td style=\"font-size: large;\">
						<div class='wrapper'>
							<input type=hidden id='Aksi".$hasil[$i]['itemid']."' name='Aksi".$hasil[$i]['itemid']."' />
							<span class='minus' onClick='document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").value=\"minus\";document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").name=\"Aksi\";document.getElementById(\"identitas\").value=\"".$hasil[$i]['itemid']."\";document.getElementById(\"daftar\").submit()'>-</span>
							<span class='num' onClick='Swal.fire({
							  text: \"How much is ".$hasil2['nama']."?\",
							  input: \"number\"
							}).then(function(result) {
							  if (result.value) {
							    const amount = result.value
							    document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").value=\"input\";
							    document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").name=\"Aksi\";
							    document.getElementById(\"identitas\").value=\"".$hasil[$i]['itemid']."\";
							    document.getElementById(\"banyakitem\").value=amount;
							    document.getElementById(\"daftar\").submit();
							  }
							})'>".$hasil[$i]['jumlah']."</span>
							<span class='plus' onClick='document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").value=\"plus\";document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").name=\"Aksi\";document.getElementById(\"identitas\").value=\"".$hasil[$i]['itemid']."\";document.getElementById(\"daftar\").submit()'>+</span>
						</div>
						</td>";
						$totalbayar += ($hasil[$i]['jumlah']*$hasil2['harga']);
				}
						
				/*$html .= "
				<td>
					<select id='Aksi".$hasil[$i]['id']."' name='Aksi".$hasil[$i]['id']."' onChange=document.getElementById('Aksi".$hasil[$i]['id']."').name='Aksi';document.getElementById('identitas').value='".$hasil[$i]['id']."';document.getElementById('daftar').submit() >
						<option value=''>--pilih aksi--</option>
						<option value='hapus'>Hapus</option>
					</select>
				</td>
				</tr>";*/
			
			}
			if($totalbayar > 0){
				$html .= "<tr>
						<td style=\"font-size: large;\">SubTotal</td>
						<td style=\"font-size: large;\">".rupiah($totalbayar)."</td>
					</tr>";
			}
			echo $html;
		}
	}
?>