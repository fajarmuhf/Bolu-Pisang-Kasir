<?php
	session_start();
	include "../secure.php";
	include "../../../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
	$banyakindex = 3;

	function rupiah($angka){
	
		$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		return $hasil_rupiah;
	 
	}
				
	if(isset($_POST['start']) && @$_POST['start'] >= 0){
		$id = $_SESSION['id'];

		$query="SELECT id FROM `user` WHERE idfacebook = ?";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("i",$id);
		$exquery->execute();
		date_default_timezone_set('Asia/Jakarta');
		$tanggal = date("Y-m-d H:i:s");
		if($exquery){
			$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

			$iduser = $tampil[0]["id"];
		}

		$start = $_POST['start'];
		
		$tglawal = $_SESSION['tglbefore'];
		$tglakhir = $_SESSION['tglafter'];

		$tglawal2 = date_create($_SESSION['tglbefore']);
		$tglakhir2 = date_create($_SESSION['tglafter']);
		$diffent = date_diff($tglawal2,$tglakhir2);

		$query = "SELECT id FROM `user` WHERE idfacebook = ?";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("i",$id);
		$exquery->execute();
		if($exquery){
			$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

			$id_pemilik = $tampil[0]["id"];
		}	

		$total_biaya_penyusutan = 0;

		$query = "SELECT * FROM `aset` WHERE id_pemilik = ?";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("i",$id_pemilik);
		$result = $exquery->execute();
		if($result){
			$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
			for($i=0;$i<count($hasil);$i++){
				$tglbeli = date_create(date("Y-m-d H:i:s",strtotime($hasil[$i]['tanggal_beli'])));
				$tglsekarang = date_create(date("Y-m-d H:i:s"));
				$diff  = date_diff( $tglbeli, $tglsekarang );
				$harga_sekarang = $hasil[$i]['harga_perolehan']-($diff->y+($diff->m)/12+($diff->d)/365)*($hasil[$i]['harga_perolehan']-$hasil[$i]['harga_sisa'])/$hasil[$i]['umur'];
				$total_biaya_penyusutan_per_hari = ($hasil[$i]['harga_perolehan']-$harga_sekarang)/365;
				//$total_biaya_penyusutan_per_hari = ($hasil[$i]['harga_perolehan']-$harga_sekarang)/365+$hasil[$i]['harga_perolehan']/($diff->y+($diff->m)/12+($diff->d)/365)/365;
				$total_biaya_penyusutan += $total_biaya_penyusutan_per_hari*($diffent->y*365+($diffent->m)*365/12+($diffent->d));
			}
		}


		$query = "SELECT * FROM clientorder as A,cart as B WHERE A.id = B.orderid AND B.userid = $iduser AND updateorder >= '$tglawal' AND updateorder <= '$tglakhir' ORDER BY updateorder DESC ";

		$exquery=mysqli_query($Koneksi->getKonek(),$query);
		$pendapatantotal = 0;
		$omsettotal = 0;
		$modaltotal = 0;
		if($result){
			$html = "";
			$html .= "<div style='overflow-x: scroll;overflow-y: scroll;height: 480px;'>";
			$html .= "<table align=center border=1 id=tabelku class=CSSTableGenerator >
					<tr>
						<td style='width:6.5%;'>Id</td>
						<td style='width:6.5%;'>Tanggal</td>
						<td style='width:6.5%;'>Pelangan/Kasir</td>
						<td style='width:6.5%;'>Driver</td>
						<td style='width:35%;'>Rincian Barang </td>
						<td style='width:6.5%;'>Alamat</td>
						<td style='width:6.5%;'>Pembayaran</td>
						<td style='width:6.5%;'>Status</td>
					";
			
			while($hasil = mysqli_fetch_array($exquery)){
				$idorder = $hasil["orderid"];
				$html .= "<tr>
						<td style=\"font-size: large; font-weight: bold;\">".$hasil['id']."</td>";
				$query3 = "SELECT * FROM `cart` WHERE orderid = ?";
				$exquery3=$Koneksi->getKonek()->prepare($query3);
				$exquery3->bind_param("i",$idorder);
				$result3 = $exquery3->execute();
				if($result3){
					$hasil3=$exquery3->get_result()->fetch_all(MYSQLI_ASSOC);
					$rincianbarang = "";
					$totalbayar = 0;
					$totalmodal = 0;
					$pendapatan = 0;
					$omset = 0;
					for($j=0;$j<count($hasil3);$j++){
						if($hasil3[$j]["usermanagerid"]==0){
							if($j==0){
								$user_id = $hasil3[$j]["userid"];
								$query2 = "SELECT * FROM `user` WHERE id = $user_id";
								$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
								if($exquery2){
									$hasil2 = mysqli_fetch_array($exquery2);
									$user_name = $hasil2['nama'];
								}
							}
							$item_id = $hasil3[$j]["itemid"];
							$query2 = "SELECT * FROM `produk` WHERE id = $item_id";
							$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
							if($exquery2){
								$hasil2 = mysqli_fetch_array($exquery2);
								$barang_name = $hasil2['nama'];
								$barang_harga = $hasil2['harga'];
								$barang_modal = $hasil2['modal'];
								$total_barang = $hasil3[$j]["jumlah"]*$barang_harga;
								$total_modal = $hasil3[$j]["jumlah"]*$barang_modal;
								$totalbayar += $total_barang;
								$totalmodal += $total_modal;
								$pendapatan += $total_barang-($total_modal);
								$omset += $total_barang;
								$rincianbarang .= $barang_name." - ".$hasil3[$j]["jumlah"]." x ".rupiah($barang_harga)." = ".rupiah($total_barang)."<br>";
							}
						}
						else{
							if($j==0){
								$user_id = $hasil3[$j]["usermanagerid"];
								$query2 = "SELECT * FROM `user` WHERE id = $user_id";
								$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
								if($exquery2){
									$hasil2 = mysqli_fetch_array($exquery2);
									$user_name = $hasil2['nama'];
									$perum = $hasil2["perum"];
									$query22 = "SELECT * FROM `perumahan` WHERE nama = '$perum'";
									$exquery22 = mysqli_query($Koneksi->getKonek(),$query22);
									if($exquery22){
										$hasil22 = mysqli_fetch_array($exquery22);
										$alamat= $perum." ".$hasil22["lokasi"];
									}	
								}
							}

							$item_id = $hasil3[$j]["itemid"];
							$query2 = "SELECT * FROM `produk` WHERE id = $item_id";
							$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
							if($exquery2){
								$hasil2 = mysqli_fetch_array($exquery2);
								$barang_name = $hasil2['nama'];
								$barang_harga = $hasil2['harga'];
								$barang_modal = $hasil2['modal'];
								$total_barang = $hasil3[$j]["jumlah"]*$barang_harga;
								$total_modal = $hasil3[$j]["jumlah"]*$barang_modal;
								$totalbayar += $total_barang;
								$totalmodal += $total_modal;
								$pendapatan += $total_barang-($total_modal);
								$omset += $total_barang;
								$rincianbarang .= $barang_name." - ".$hasil3[$j]["jumlah"]." x ".rupiah($barang_harga)." = ".rupiah($total_barang)."<br>";
							}
						}
					}
					$biayaongkir = $hasil["biayaongkir"];
					$totalbayar += $biayaongkir;
					$kodeunik = $hasil["kodeunik"];
					if($kodeunik!=""){
						$rincianbarang .= "<b style=\"color: purple;\">Kode Unik = ".$kodeunik."<br>";
						$totalbayar += $kodeunik;
						$omset += $kodeunik;
						$pendapatan += $kodeunik;
					}
					$pendapatantotal += $pendapatan;
					$modaltotal += $totalmodal;
					$omsettotal += $omset;
					$rincianbarang .= "<br><b style=\"color: coral;\">Biaya Ongkir = ".rupiah($biayaongkir)."<br>";
					$rincianbarang .= "<b style=\"color: red;\">SubTotal Modal = ".rupiah($totalmodal)."<br>";
					$rincianbarang .= "<b style=\"color: blue;\">SubTotal Bayar = ".rupiah($totalbayar)."<br>";
					$rincianbarang .= "<b style=\"color: green;\">Pendapatan = ".rupiah($pendapatan)."<br>";
					$rincianbarang .= "<b style=\"color: magenta;\">Omset = ".rupiah($omset);
				}
				if($hasil["driverid"]==NULL){
					$driver="";
				}
				else{
					$driver_id = $hasil["driverid"];
					$query2 = "SELECT * FROM `driver` WHERE id = $driver_id";
					$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
					if($exquery2){
						$hasil2 = mysqli_fetch_array($exquery2);
						$driver_name = $hasil2['nama'];
					}
					$driver = $driver_id." - ".$driver_name;
				}
				$alamat = "";
				if($hasil["alamat"]!=""){
					$alamat = $hasil["alamat"];
				}
				$status = $hasil[9];
				$restock = $hasil["restock"];
				$uang_diterima = $hasil["uang_diterima"];
				$pembayaran = $hasil["pembayaran"];
				$tanggalupdate = $hasil["updateorder"];
				$html .= "<td style=\"font-size: large; font-weight: bold;\">".$tanggalupdate."</td>";
				$html .= "<td style=\"font-size: large; font-weight: bold;\">".$user_id." - ".$user_name."</td>";
				$html .= "<td style=\"font-size: large; font-weight: bold;\">".$driver."</td>";
				$html .= "<td style=\"font-size: small; font-weight: bold;\">".$rincianbarang."</td>";
				$html .= "<td style=\"font-size: large; font-weight: bold;\">".$alamat."</td>";
				$html .= "<td style=\"font-size: large; font-weight: bold;\">".$pembayaran."</td>";
				if($status=="Dibatalkan")$html .= "<td style=\"font-size: large; font-weight: bold;color: red;\">".$status."</td>";
				else if($status=="selesai")$html .= "<td style=\"font-size: large; font-weight: bold;color: green;\">".$status."</td>";
				else $html .= "<td style=\"font-size: large; font-weight: bold;\">".$status."</td>";
				
					
			
			}
			$pendapatantotal -= $total_biaya_penyusutan;
			$html .= "</table>";
			$html .= "</div>";
			echo $html;
		}
	}
?>