<?php
	
	session_start();
	//memanggil library
	include("../../../../jpgraph/src/jpgraph.php");
	include("../../../../jpgraph/src/jpgraph_bar.php");
	include("../../../../jpgraph/src/jpgraph_table.php");
	
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
	$sumbuys2 = array();
	$sumbuy3 = array();
	$sumbuys3 = array();
	$sumbus = array();
	if($exquery){
		for($i=0;$i<count($hasil);$i++){
			if(!is_array(@$sumbuys3[0])){
				$sumbuys3[0] = array();
			}
			array_push($sumbuys3[0],$hasil[$i]['updateorder']);
		}
	}
	$n=0;
	$max = 0;
	$maximum = 0;
	if($exquery){
		for($i=0;$i<count($hasil);$i++){
			$idorder = $hasil[$i]["id"];
			
			$query3 = "SELECT * FROM `cart` WHERE orderid = ?";
			$exquery3=$Koneksi->getKonek()->prepare($query3);
			$exquery3->bind_param("i",$idorder);
			$result3 = $exquery3->execute();
			$max = 0;
			if($result3){
				$hasil3=$exquery3->get_result()->fetch_all(MYSQLI_ASSOC);
				$totalbayar = 0;
				$sumbuy2[$i] = array();
				$sumbuys2[$i] = array();
				for($j=0;$j<count($hasil3);$j++){
					$item_id = $hasil3[$j]["itemid"];
					$query2 = "SELECT * FROM `produk` WHERE id = $item_id";
					$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
					if($exquery2){
						$hasil2 = mysqli_fetch_array($exquery2);
						$nama_barang = $hasil2['nama'];
						$barang_harga = $hasil2['harga'];
						$total_barang = $hasil3[$j]["jumlah"]*$barang_harga;
						$totalbayar += $total_barang;
						array_push($sumbuy2[$i],$total_barang);	
						array_push($sumbuys2[$i],$nama_barang." : ".$hasil3[$j]["jumlah"]);	
						
						$max++;
						if($max > $maximum){
							$maximum = $max;
						}
					}
				}
			}
			$sumbux[$n] = $hasil[$i]['updateorder'];
			$sumbuy[$n] = $totalbayar;
			$n++;
		}
		for($i=0;$i<count($sumbuy2);$i++){
			if(!isset($sumbuy2[$i][$maximum-1])){
				for($j=0;$j<$maximum;$j++){
					if(!isset($sumbuy2[$i][$j])){
						array_push($sumbuy2[$i],0);
						array_push($sumbuys2[$i],"");
					}
				}
			}
		}
		for($i=0;$i<$maximum;$i++){
			for($j=0;$j<count($sumbuy2);$j++){
				if(!is_array(@$sumbuy3[$i])){
					$sumbuy3[$i] = array();
					$sumbuys3[$i+1] = array();
				}
				array_push($sumbuy3[$i],$sumbuy2[$j][$i]);
				array_push($sumbuys3[$i+1],$sumbuys2[$j][$i]);
			}
			$bplot = new BarPlot($sumbuy3[$i]);
			array_push($sumbus,$bplot);
		}

	//Slice Color
	$colorslice = array('#1E90FF','#2E8B57','#ADFF2F','#BA55D3');
	
	$nbrbar = count($sumbuy2);
	$nbrbar2 = count($sumbuy2[0]);
	$cellwidth = 180;
	$cellheight = 25;
	$tableypos = 200;
	$tablexpos = 60;
	$tablewidth = $nbrbar*$cellwidth;
	$tableheight = 225+$nbrbar2*$cellheight;
	$rightmargin = 50;
	$topmargin = 50;

	$height = $tableheight;  // a suitable height for the image
	$width = $tablexpos+$tablewidth+$rightmargin; // the width of the image

	$tampil = new Graph($width,$height);	
	$tampil->img->SetMargin($tablexpos,$rightmargin,$topmargin,$height-$tableypos);
	$tampil->SetScale('textlin');
	$tampil->SetMarginColor('white');
		
	//Membuat Judul dari Grafik
	$tampil->title->Set('Data Data Penjualan');
	
	//Menampilkan grid untuk sumbu X
	$tampil->xgrid->Show();
	//Menampilkan jenis garisnya dot atau solid atau yang lain
	$tampil->xgrid->SetLineStyle("solid");
	//Menampilkan data dari sumbu X
	//Mengeset Warna
	$tampil->xgrid->SetColor('white');
	$tampil->yaxis->SetFont(FF_VERDANA,FS_NORMAL,5);
	
	//Mengeplot Grafik
	//$garis = new BarPlot($sumbuy);

	//Menambahkan plot ke dalam grafik dengan cara menambahkan object garis ke dalam object tampil
	//Mengeset warna untuk sumbu y
	//$garis->SetColor("red");
	//Mengeset Slice Color 
	//$garis->SetSliceColors($colorslice);
	//Membuat Le

	$table = new GTextTable();
	//var_dump($sumbuys3);
	$table->Set($sumbuys3);
	$table->SetPos($tablexpos,$tableypos+1);

	$table->SetFont(FF_ARIAL,FS_NORMAL,10);
	$table->SetAlign('right');
	$table->SetMinColWidth($cellwidth);
	$table->SetNumberFormat('%0.1f');

	// Format table header row
	$table->SetRowFillColor(0,'teal@0.7');
	$table->SetRowFont(0,FF_ARIAL,FS_BOLD,11);
	$table->SetRowAlign(0,'center');

	// .. and add it to the graph
	$tampil->Add($table);
	//$tampil->Add($table);

	$accbplot = new AccBarPlot($sumbus);
	$accbplot->value->Show();
	$tampil->Add($accbplot);
	
	//Menampilkan grafik
	$tampil->Stroke();
	$fileName = "bargraph.png";
    $tampil->img->Stream($fileName);
	
	}
	
	mysql_close($koneksi->getKonek());
	
?>
