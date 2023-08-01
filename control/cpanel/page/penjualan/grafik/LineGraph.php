<?php
	session_start();
	//memanggil library
	include("../../../../jpgraph/src/jpgraph.php");
	include("../../../../jpgraph/src/jpgraph_line.php");
	
	//membuat data mahasiswa IT
	//membuat data untuk ditampilkan pada sumbu X
	include "../include/koneksi.php";
	
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
	
	$tglawal = $_SESSION['tglbefore2'];
	$tglakhir = $_SESSION['tglafter2'];

	$query = "SELECT * FROM `clientorder` WHERE updateorder >= '$tglawal' AND updateorder <= '$tglakhir' ORDER BY updateorder ASC ";
	$exquery=$Koneksi->getKonek()->prepare($query);
	$result = $exquery->execute();
	if($result){
		$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
	}
	
	$sumbux = array();
	$sumbuy = array();
	$sumbuy2 = array();
	
	
	$n=0;
	if($exquery){
		for($i=0;$i<count($hasil);$i++){
			$idorder = $hasil[$i]["id"];
				
			$query3 = "SELECT * FROM `cart` WHERE orderid = ?";
			$exquery3=$Koneksi->getKonek()->prepare($query3);
			$exquery3->bind_param("i",$idorder);
			$result3 = $exquery3->execute();
			if($result3){
				$hasil3=$exquery3->get_result()->fetch_all(MYSQLI_ASSOC);
				$totalbayar = 0;
				for($j=0;$j<count($hasil3);$j++){
					$item_id = $hasil3[$j]["itemid"];
					$query2 = "SELECT * FROM `produk` WHERE id = $item_id";
					$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
					if($exquery2){
						$hasil2 = mysqli_fetch_array($exquery2);
						$barang_harga = $hasil2['harga'];
						$total_barang = $hasil3[$j]["jumlah"]*$barang_harga;
						$totalbayar += $total_barang;
					}
				}
			}
			$sumbux[$n] = $hasil[$i]['updateorder'];
			$sumbuy[$n] = $totalbayar;
			$n++;
		}
	//Slice Color
	$colorslice = array('#1E90FF','#2E8B57','#ADFF2F','#BA55D3');
	
	
	//Menentukan Area Grapfik dengan membuat Object dari Class Graph
	$tampil = new Graph(1024,600,"auto");
	//Menentukan Jenis Grafik yang akan ditampilkan,library harus didefinisikan dahulu di include
	$tampil->SetScale("textlin",0,0,0,0);
	
	//Membuat Judul dari Grafik
	$tampil->title->Set('Data Data Penjualan');
	
	//Menampilkan grid untuk sumbu X
	$tampil->xgrid->Show();
	//Menampilkan jenis garisnya dot atau solid atau yang lain
	$tampil->xgrid->SetLineStyle("solid");
	//Menampilkan data dari sumbu X
	$tampil->xaxis->SetTickLabels($sumbux);
	$tampil->xaxis->SetFont(FF_VERDANA,FS_NORMAL,5);
	$tampil->xaxis->SetLabelAngle(90);
	$tampil->yaxis->SetFont(FF_VERDANA,FS_NORMAL,5);
	//Mengeset Warna
	$tampil->xgrid->SetColor('white');

	//Mengeplot Grafik
	$garis = new LinePlot($sumbuy);
	//Menambahkan plot ke dalam grafik dengan cara menambahkan object garis ke dalam object tampil
	//Mengeset warna untuk sumbu y
	$garis->SetColor("red");
	//Mengeset Slice Color 
	//$garis->SetSliceColors($colorslice);
	//Membuat Legend untuk garis
	
	$tampil->Add($garis);
	
	//Menampilkan grafik
	$tampil->Stroke();
	$fileName = "linegraph.png";
    $tampil->img->Stream($fileName);
	
	}
	
	mysql_close($koneksi->getKonek());
	
?>
