<?php
	session_start();
	require('../../../fpdf/fpdf.php');
	
	//membuat footer
	include "page/layout.php";
	include "include/koneksi.php";
	
	$width=850;
	$height=600;
	$fpdf = new PDF('P', 'pt', array($height,$width));
	$fpdf->SetAutoPageBreak(false,20);
	
	
	$fpdf->AddPage('P','A4');
	$fpdf->SetLink($fpdf->nav[2]);
	
	
	//mengeset judul dan nama pemulis
	$fpdf->SetTextColor(0,0,80);
	$fpdf->SetMargins(220,10,3);
	$fpdf->SetTitle('Laporan Penjualan Fandy Store');
	$fpdf->SetAuthor('Fajar MF');
	$fpdf->SetY(70);
	$fpdf->Cell(55,20,'Data Data Penjualan');
	//menset awal X dan Y
	$fpdf->SetFont('Courier','B',5);
	
	$fpdf->SetY(150);
	$header = array('Id', 'Tanggal','Pelanggan/Kasir','Driver','Rincian Barang','Alamat','Pembayaran','Status','Restock','Uang Diterima');
	// Data loading
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
	

	$tglawal = $_SESSION['tglbefore'];
	$tglakhir = $_SESSION['tglafter'];

	$query = "SELECT * FROM `clientorder` WHERE updateorder >= '$tglawal' AND updateorder <= '$tglakhir' ORDER BY updateorder DESC ";
	$exquery = mysqli_query($Koneksi->getKonek(),$query);
	
	if($exquery){
		$tulis = "";
		while($hasil = mysqli_fetch_array($exquery)){
			$idorder = $hasil["id"];
			$query3 = "SELECT * FROM `cart` WHERE orderid = ?";
			$exquery3=$Koneksi->getKonek()->prepare($query3);
			$exquery3->bind_param("i",$idorder);
			$result3 = $exquery3->execute();
			if($result3){
				$hasil3=$exquery3->get_result()->fetch_all(MYSQLI_ASSOC);
				$rincianbarang = "";
				$totalbayar = 0;
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
							$total_barang = $hasil3[$j]["jumlah"]*$barang_harga;
							$totalbayar += $total_barang;
							$rincianbarang .= $barang_name." - ".$hasil3[$j]["jumlah"]." x ".$barang_harga." = ".$total_barang."<br>";
						}
					}
					else{
						if($j==0){
							$user_id = $hasil3[$j]["usermanagerid"];
							$query2 = "SELECT * FROM `user-manager` WHERE id = $user_id";
							$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
							if($exquery2){
								$hasil2 = mysqli_fetch_array($exquery2);
								$user_name = $hasil2['Username'];
								$perum = $hasil2["Perum"];
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
							$total_barang = $hasil3[$j]["jumlah"]*$barang_harga;
							$totalbayar += $total_barang;
							$rincianbarang .= $barang_name." - ".$hasil3[$j]["jumlah"]." x ".$barang_harga." = ".$total_barang."<br>";
						}
					}
				}
				$biayaongkir = $hasil["biayaongkir"];
				$totalbayar += $biayaongkir;
				$kodeunik = $hasil["kodeunik"];
				if($kodeunik!=""){
					$rincianbarang .= "<b style=\"color: purple;\">Kode Unik = ".$kodeunik."<br>";
					$totalbayar += $kodeunik;
				}
				$rincianbarang .= "<b style=\"color: coral;\">Biaya Ongkir = ".$biayaongkir."<br>";
				$rincianbarang .= "<b style=\"color: blue;\">SubTotal = ".$totalbayar;
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
			if($hasil["alamat"]!=""){
				$alamat = $hasil[$i]["alamat"];
			}
			$status = $hasil["status"];
			$restock = $hasil["restock"];
			$uang_diterima = $hasil["uang_diterima"];
			$pembayaran = $hasil["pembayaran"];
			$tanggalupdate = $hasil["updateorder"];
			$tulis .= $hasil['id'].";";
			$tulis .= $hasil['updateorder'].";";
			$tulis .= $user_id." - ".$user_name.";";
			$tulis .= $driver.";";
			$tulis .= $rincianbarang." ;";
			$tulis .= $alamat.";";
			$tulis .= $pembayaran.";";
			$tulis .= $status.";";
			$tulis .= $restock.";";
			$tulis .= $uang_diterima.";\n";
		}
		$fileku = fopen('tabel/daftar_isi.txt',"w");
		fwrite($fileku,$tulis);
		fclose($fileku);
	}
	else{
		echo "Gagal koneksi ke Database";
	}
	
	$data = $fpdf->LoadData('tabel/daftar_isi.txt');
	$fpdf->FancyTable($header,$data);
	
	include "grafikpdf.php";
	
	$fpdf->Output();
?>
