<?php
	session_start();
	include "../../../../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
	$banyakindex = 3;
				
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
						<td style=\"font-size: large; font-weight: bold;\">".$hasil2['nama']."</td>
						<td><a href='../../images/".$hasil2['imageurl']."'  onclick='return hs.expand(this)' class='highslide'><img src='../../images/".$hasil2['imageurl']."' width=120px height=120px ></a></td>
						<td style=\"font-size: large;\">".$hasil[$i]['jumlah']."</td>
						<td style=\"font-size: large;\">".$hasil2['harga']."</td>
						<td style=\"font-size: large;\">".($hasil[$i]['jumlah']*$hasil2['harga'])."</td>";
						$totalbayar += ($hasil[$i]['jumlah']*$hasil2['harga']);
				}
						
				$html .= "
				<td>
					<select id='Aksi".$hasil[$i]['id']."' name='Aksi".$hasil[$i]['id']."' onChange=document.getElementById('Aksi".$hasil[$i]['id']."').name='Aksi';document.getElementById('identitas').value='".$hasil[$i]['id']."';document.getElementById('daftar').submit() >
						<option value=''>--pilih aksi--</option>
						<option value='hapus'>Hapus</option>
					</select>
				</td>
				</tr>";
			
			}
			$html .= "<tr>
						<td style=\"font-size: large; font-weight: bold;\"></td>
						<td></td>
						<td style=\"font-size: large;\"></td>
						<td style=\"font-size: large;\">SubTotal</td>
						<td style=\"font-size: large;\">".$totalbayar."</td>
						<td></td>
					</tr>";
			echo $html;
		}
	}
?>