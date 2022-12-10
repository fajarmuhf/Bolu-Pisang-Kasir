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
	$fpdf->SetLink($fpdf->nav[2]);
	
	
	//mengeset judul dan nama pemulis
	$fpdf->SetTextColor(0,0,80);
	$fpdf->SetMargins(220,10,3);
	$fpdf->SetTitle('Pemograman Internet 2');
	$fpdf->SetAuthor('Fajar MF');
	$fpdf->SetY(70);
	$fpdf->Cell(55,20,'Daftar Data User');
	//menset awal X dan Y
	$fpdf->SetFont('Courier','B',12);
	
	$fpdf->SetY(150);
	$header = array('Id', 'Username','Password','Status');
	// Data loading
	$Koneksi = new Hubungi();
	$Koneksi->Konek("bolu_pisang");
	
	$query = "SELECT * FROM User WHERE 1";
	$exquery = mysql_query($query);
	
	if($exquery){
		$tulis = "";
		while($hasil = mysql_fetch_array($exquery)){
			$tulis .= $hasil['Id'].";";
			$tulis .= $hasil['Username'].";";
			$tulis .= $hasil['Password'].";";
			$tulis .= $hasil['Status'].";\n";
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
