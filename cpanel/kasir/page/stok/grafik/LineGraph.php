<?php
	//memanggil library
	include("../../../../jpgraph/src/jpgraph.php");
	include("../../../../jpgraph/src/jpgraph_line.php");
	
	//membuat data mahasiswa IT
	//membuat data untuk ditampilkan pada sumbu X
	include "../include/koneksi.php";
	
	$koneksi = new Hubungi();
	$koneksi->Konek("bolu_pisang");
	
	$query = "SELECT * FROM Stok WHERE 1";
	$exquery = mysql_query($query);
	
	$sumbux = array();
	$sumbuy = array();
	$sumbuy2 = array();
	
	
	$i=0;
	if($exquery){
		while($hasil = mysql_fetch_array($exquery)){
			$sumbux[$i] = $hasil['Id_Barang'];
			$sumbuy[$i] = $hasil['Jumlah'];
			$sumbuy2[$i] = $hasil['Id_User'];
			$i++;
		}
	//Slice Color
	$colorslice = array('#1E90FF','#2E8B57','#ADFF2F','#BA55D3');
	
	
	//Menentukan Area Grapfik dengan membuat Object dari Class Graph
	$tampil = new Graph(500,450,"auto");
	//Menentukan Jenis Grafik yang akan ditampilkan,library harus didefinisikan dahulu di include
	$tampil->SetScale("textlin",0,0,0,0);
	
	//Membuat Judul dari Grafik
	$tampil->title->Set('Data Data Stok');
	
	//Menampilkan grid untuk sumbu X
	$tampil->xgrid->Show();
	//Menampilkan jenis garisnya dot atau solid atau yang lain
	$tampil->xgrid->SetLineStyle("solid");
	//Menampilkan data dari sumbu X
	$tampil->xaxis->SetTickLabels($sumbux);
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
	$garis->SetLegend('Jumlah');
	
	//Mengeplot Grafik
	
	$garis2 = new LinePlot($sumbuy2);
	//Menambahkan plot ke dalam grafik dengan cara menambahkan object garis ke dalam object tampil
	//Mengeset warna untuk sumbu y
	$garis2->SetColor("blue");
	//Mengeset Slice Color 
	//$garis->SetSliceColors($colorslice);
	//Membuat Legend untuk garis
	$garis2->SetLegend('Id_User');
	
	$tampil->Add($garis);
	$tampil->Add($garis2);
	
	
	//Menampilkan grafik
	$tampil->Stroke();
	$fileName = "linegraph.png";
    $tampil->img->Stream($fileName);
	
	}
	
	mysql_close($koneksi->getKonek());
	
?>
