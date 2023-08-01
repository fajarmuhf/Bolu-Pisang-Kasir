<?php
	require('../../../fpdf/fpdf.php');
	
	//membuat footer
	include "page/layout.php";
	include "include/koneksi.php";
	
	$width=850;
	$height=600;
	$fpdf = new PDF('P', 'pt', array($height,$width));
	$fpdf->SetAutoPageBreak(false,20);
	
	
	$fpdf->AddPage('P','A4');
	$fpdf->SetLink($fpdf->nav[1]);
	
	
	//mengeset judul dan nama pemulis
	$fpdf->SetFont('Courier','B',24);
	$fpdf->SetTextColor(0,0,80);
	$fpdf->SetMargins(180,10,3);
	$fpdf->SetTitle('Pemograman Internet 2');
	$fpdf->SetAuthor('Fajar MF');
	$fpdf->SetY(70);
	$fpdf->Cell(55,20,'Table Data Barang');
	//menset awal X dan Y
	$fpdf->SetFont('Courier','B',12);
	
	$fpdf->SetY(150);
	$header = array('Id', 'Nama','Harga','Tahun','Gambar');
	// Data loading
	$Koneksi = new Hubungi();
	$Koneksi->Konek("bolu_pisang");
	
	$query = "SELECT * FROM Barang WHERE 1";
	$exquery = mysql_query($query);
	
	if($exquery){
		$tulis = "";
		while($hasil = mysql_fetch_array($exquery)){
			$tulis .= $hasil['Id'].";";
			$tulis .= $hasil['Nama'].";";
			$tulis .= $hasil['Harga'].";";
			$tulis .= $hasil['Keterangan'].";";
			$tulis .= $hasil['Gambar'].";\n";
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
	
	$fpdf->SetFont('Courier','B',12);
	$fpdf->SetMargins(400,3,3);
	$fpdf->setY(130+(2*150));
	$fpdf->SetTextColor(0,100,0);
	$fpdf->Cell(0,2,"Jakarta,".date('d-M-Y'));
	$fpdf->SetMargins(430,3,3);
	$fpdf->ln(0.5);
	$fpdf->Cell(0,30,'Dibuat Oleh');
	$fpdf->SetMargins(410,3,3);
	$fpdf->ln(50.5);
	$fpdf->Cell(0,30,'Fajar Muhammad F');
	
	include "grafikpdf.php";

	$fpdf->Output();
?>
