<?php
	$fpdf->AddPage('P','A4');
	$fpdf->SetLink($fpdf->nav[2]);
	
	//mengeset judul dan nama pemulis
	$fpdf->SetFont('Courier','B',24);
	$fpdf->SetTextColor(0,0,80);
	$fpdf->SetMargins(180,10,3);
	$fpdf->SetTitle('Pemograman Internet 2');
	$fpdf->SetAuthor('Fajar MF');
	$fpdf->SetY(70);
	$fpdf->Cell(55,20,'Grafik Data Barang');
	//menset awal X dan Y
	$fpdf->SetFont('Courier','B',12);
	
	$fpdf->SetY(150);
	
	$fpdf->image('grafik/bargraph.png',170,135,250,250);

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
	
	$fpdf->AddPage('P','A4');
	$fpdf->SetLink($fpdf->nav[3]);
	
	//mengeset judul dan nama pemulis
	$fpdf->SetFont('Courier','B',24);
	$fpdf->SetTextColor(0,0,80);
	$fpdf->SetMargins(180,10,3);
	$fpdf->SetTitle('Pemograman Internet 2');
	$fpdf->SetAuthor('Fajar MF');
	$fpdf->SetY(70);
	$fpdf->Cell(55,20,'Grafik Data Barang');
	//menset awal X dan Y
	$fpdf->SetFont('Courier','B',12);
	
	$fpdf->SetY(150);
	
	$fpdf->image('grafik/linegraph.png',170,135,250,250);

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
	

	$fpdf->AddPage('P','A4');
	$fpdf->SetLink($fpdf->nav[4]);
	
	//mengeset judul dan nama pemulis
	$fpdf->SetFont('Courier','B',24);
	$fpdf->SetTextColor(0,0,80);
	$fpdf->SetMargins(180,10,3);
	$fpdf->SetTitle('Pemograman Internet 2');
	$fpdf->SetAuthor('Fajar MF');
	$fpdf->SetY(70);
	$fpdf->Cell(55,20,'Grafik Data Barang');
	//menset awal X dan Y
	$fpdf->SetFont('Courier','B',12);
	
	$fpdf->SetY(150);
	
	$fpdf->image('grafik/piegraph.png',170,135,250,250);

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
?>
