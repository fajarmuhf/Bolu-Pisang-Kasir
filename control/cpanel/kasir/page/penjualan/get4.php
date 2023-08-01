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
		$tglakhir = date("Y-m-d", strtotime($_SESSION['tglafter']));

		$query="SELECT Id,Perum FROM `user-manager` WHERE Username = ? AND Password = ?";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("ss",$username,$password);
		$exquery->execute();
		$tanggal = date("Y-m-d H:i:s");
		$tanggaldate = date("Y-m-d");
		if($exquery){
			$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

			$iduser = $tampil[0]["Id"];
			$perum = $tampil[0]["Perum"];
		}

		$start = $_POST['start'];		
		$query = "SELECT * FROM `pengiriman` WHERE usermanagerid = $iduser AND perum = '$perum' AND tanggal = '$tglakhir' limit ?,$banyakindex";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("i",$start);
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
						<td style=\"font-size: large; font-weight: bold;width: 60%;\">
							".$hasil2['nama']."<br>
							<a href='../images/".$hasil2['imageurl']."'  onclick='return hs.expand(this)' class='highslide'><img src='../images/".$hasil2['imageurl']."' width=120px height=120px ></a>
						</td>";
				}
						
				$html .= "
				<td style=\"font-size: large;\">		
					<div class='wrapper'>
						<input type=hidden id='Aksi".$hasil[$i]['itemid']."' name='Aksi".$hasil[$i]['itemid']."' />
						<span class='minus' onClick='document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").value=\"minus\";document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").name=\"Aksi\";document.getElementById(\"identitas\").value=\"".$hasil[$i]['itemid']."\";document.getElementById(\"daftar\").submit()'>-</span>
						<span class='num' onClick='Swal.fire({
						  text: \"How much is ".$hasil2['nama']."?\",
						  input: \"number\"
						}).then(function(result) {
						  if (result.value) {
						    const amount = result.value;
						    document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").value=\"input\";
						    document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").name=\"Aksi\";
						    document.getElementById(\"identitas\").value=\"".$hasil[$i]['itemid']."\";
						    document.getElementById(\"banyakitem\").value=amount;
						    document.getElementById(\"daftar\").submit();
						  }
						})'>".$hasil[$i]['jumlah']."</span>
						<span class='plus' onClick='document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").value=\"plus\";document.getElementById(\"Aksi".$hasil[$i]['itemid']."\").name=\"Aksi\";document.getElementById(\"identitas\").value=\"".$hasil[$i]['itemid']."\";document.getElementById(\"daftar\").submit()'>+</span>
					</div>
				</td>
				</tr>";
			
			}
			echo $html;
		}
	}
?>