<?php
	//memanggil library
	include("jpgraph/src/jpgraph.php");
	include("jpgraph/src/jpgraph_bar.php");
	
	//membuat data mahasiswa IT
	//membuat data untuk ditampilkan pada sumbu X
	$sumbux = array('2009','2010','2011','2012');
	//membuat data untuk ditampilkan pada sumbu Y
	$sumbuy = array('15','40','28','45');
	//Slice Color
	$colorslice = array('#1E90FF','#2E8B57','#ADFF2F','#BA55D3');
	
	
	//Menentukan Area Grapfik dengan membuat Object dari Class Graph
	$tampil = new Graph(500,450,"auto");
	//Menentukan Jenis Grafik yang akan ditampilkan,library harus didefinisikan dahulu di include
	$tampil->SetScale("textlin");
	
	//Membuat Judul dari Grafik
	$tampil->title->Set('Jumlah Mahasiswa Teknik Informatika Univeritas Pancasila');
	
	//Menampilkan grid untuk sumbu X
	$tampil->xgrid->Show();
	//Menampilkan jenis garisnya dot atau solid atau yang lain
	$tampil->xgrid->SetLineStyle("solid");
	//Menampilkan data dari sumbu X
	$tampil->xaxis->SetTickLabels($sumbux);
	//Mengeset Warna
	$tampil->xgrid->SetColor('white');
	
	//Mengeplot Grafik
	$garis = new BarPlot($sumbuy);
	//Menambahkan plot ke dalam grafik dengan cara menambahkan object garis ke dalam object tampil
	$tampil->Add($garis);
	//Mengeset warna untuk sumbu y
	$garis->SetColor("red");
	//Mengeset Slice Color 
	//$garis->SetSliceColors($colorslice);
	//Membuat Legend untuk garis
	$garis->SetLegend('Banyaknya Mahasiswa ITUP');
	
	//Menampilkan grafik
	$tampil->Stroke();
?>
