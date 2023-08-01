<?php
	session_start();
	include "../secure.php";

	include "../../../include/koneksi.php";
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
		$namaperumahan = $_SESSION['perum'];

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

		$subtotalpengiriman = 0;
		$subtotalretur = 0;
		$subtotalkirim = 0;
		$subtotaljual = 0;

		$start = $_POST['start'];
		$query2 = "SELECT * FROM `produk` WHERE stock != 0 AND perum = ?";
		$exquery2=$Koneksi->getKonek()->prepare($query2);
		$exquery2->bind_param("s",$namaperumahan);
		$result2 = $exquery2->execute();
		if($exquery2){
			$html = "";
			$html .= "<div style='overflow-x: scroll;overflow-y: scroll;height: 300px;'>";
			$html .= "<table align=center border=1 id=tabelku class=CSSTableGenerator >
					<tr>
						<th></th>
					</tr>";
			
			$tampil=$exquery2->get_result()->fetch_all(MYSQLI_ASSOC);
			for($j=0;$j<count($tampil);$j++){
				$itemid = $tampil[$j]["id"];
				$imageurl = $tampil[$j]["imageurl"];
				$namaproduk = $tampil[$j]["nama"];
				$stokproduk = $tampil[$j]["stock"];
				$totalpengiriman = 0;
				$totalretur = 0;
				$totalkirim = 0;
				$totaljual = 0;

				$query = "SELECT * FROM `pengiriman` WHERE itemid = '$itemid' AND perum = '$namaperumahan' AND tanggal = '$tglakhir'";
				$exquery=$Koneksi->getKonek()->prepare($query);
				$result = $exquery->execute();
				if($result){
					$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
					for($i=0;$i<count($hasil);$i++){
						$banyak = $hasil[$i]["jumlah"];
						$totalpengiriman += $banyak;
					}
				}		
				$query = "SELECT * FROM `keluar` WHERE itemid = '$itemid' AND perum = '$namaperumahan' AND tanggal = '$tglakhir'";
				$exquery=$Koneksi->getKonek()->prepare($query);
				$result = $exquery->execute();
				if($result){
					$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
					for($i=0;$i<count($hasil);$i++){
						$banyak = $hasil[$i]["jumlah"];
						if(strcmp($hasil[$i]['status'],'retur') == 0){
							$totalretur += $banyak;
						}
						else{
							$totalkirim += $banyak;
						}
					}
				}		
				$query = "SELECT * FROM `cart` as A , clientorder as B WHERE A.orderid = B.id AND A.itemid = '$itemid' AND B.perum = '$namaperumahan' AND B.updateorder LIKE '$tglakhir%'";
				$exquery=$Koneksi->getKonek()->prepare($query);
				$result = $exquery->execute();
				if($result){
					$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
					for($i=0;$i<count($hasil);$i++){
						$banyak = $hasil[$i]["jumlah"];
						$totaljual += $banyak;
					}
				}		
				
				$html .= "<tr>
					<td style=\"font-size: large; font-weight: bold;width: 60%;\">
					".$namaproduk."<br><br>
					Stok : ".$stokproduk."<br>
					Masuk : ".$totalpengiriman."<br>
					Keluar : ".$totaljual."<br>
					Retur : ".$totalretur."<br>
					Kirim : ".$totalkirim."<br><br>

					<a href='../images/".$imageurl."'  onclick='return hs.expand(this)' class='highslide'><img src='../images/".$imageurl."' width=120px height=120px ></a>
				</td>
				</tr>";

				$subtotalpengiriman += $totalpengiriman;
				$subtotaljual += $totaljual;
				$subtotalretur += $totalretur;
				$subtotalkirim += $totalkirim;
					
			}
			$html .= "</table>";
			$html .= "</div>";
			$html .= "<div style='overflow-x: scroll;overflow-y: scroll;'>";
			$html .= "<table align=center border=1 id=tabelku2 class=CSSTableGenerator >";
			$html .= "<tr>
						<th></th>
					</tr>
					<tr>
						<td style=\"text-align:left;font-size: small;\">
							Masuk : ".$subtotalpengiriman."<br>
							Keluar : ".$subtotaljual."<br>
							Retur : ".$subtotalretur."<br>
							Kirim : ".$subtotalkirim."<br><br>
						</td>
					</tr>";
			$html .= "</table>";
			$html .= "</div>";
			
			echo $html;
				
		}		
		
	}
?>