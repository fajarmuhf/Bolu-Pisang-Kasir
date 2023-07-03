<?php
	session_start();
	include "../../../../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
	$banyakindex = 3;
				
	if(isset($_POST['key']) && @$_POST['key'] != ""){
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
		$barcode = $_POST['key'];
		$query="SELECT id FROM `produk` WHERE barcode = ?";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("s",$barcode);
		$exquery->execute();
		if($exquery){
			$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

			$itemid = $tampil[0]["id"];
		}
		$banyakitem = 1;
		$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("ss",$username,$password);
		$exquery->execute();
		$tanggal = date("Y-m-d H:i:s");
		if($exquery){
			$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

			$iduser = $tampil[0]["Id"];
		}
		$query2 = "SELECT id,COUNT(*) FROM `cart` WHERE itemid = $itemid AND usermanagerid = $iduser AND status = 'belumbayar'";
		$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
		if($exquery2){
			$hasil2 = mysqli_fetch_array($exquery2);
			if($hasil2["COUNT(*)"] > 0){
				$idcart = $hasil2["id"];
				$query = "UPDATE `cart` SET jumlah = jumlah + ?,tanggal = ?,tanggalupdate = ? WHERE id = ? ";
				$exquery=$Koneksi->getKonek()->prepare($query);
				$exquery->bind_param("issi",$banyakitem,$tanggal,$tanggal,$idcart);
				$result = $exquery->execute();
				if($result){
					//echo "Anda telah berhasil menginput data ke keranjang<br>";
				}
				else{
					//echo "Anda tidak berhasil menginput data ke keranjang<br>";
				}
			}
			else{

				$query = "INSERT INTO `cart` SELECT (COUNT(*)+1),0,?,?,?,?,0,'belumbayar',NULL,?,? FROM `cart` WHERE 1 ";
				$exquery=$Koneksi->getKonek()->prepare($query);
				$exquery->bind_param("iisiss",$iduser,$itemid,$username,$banyakitem,$tanggal,$tanggal);
				$result = $exquery->execute();
				if($result){
					//echo "Anda telah berhasil menginput data ke keranjang<br>";
				}
				else{
					//echo "Anda tidak berhasil menginput data ke keranjang<br>";
				}		
			}
		}
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
						<td style=\"font-size: large; font-weight: bold;\">".$hasil2['nama']."</td>
						<td><a href='../../../images/".$hasil2['imageurl']."'  onclick='return hs.expand(this)' class='highslide'><img src='../../../images/".$hasil2['imageurl']."' width=120px height=120px ></a></td>
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