<?php
	session_start();
	include "../secure.php";

	include "../../../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
	$banyakindex = 3;
			

	$kueh = "SELECT Id FROM `user-manager` WHERE Username = '".$_SESSION['username']."'";
	$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
	if($exkueh){
		$hasilkueh = mysqli_fetch_array($exkueh);
		$id_pemilik = $hasilkueh["Id"];
	}	

	function rupiah($angka){
	
		$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		return $hasil_rupiah;
	 
	}
		
	if(isset($_POST['start']) && @$_POST['start'] >= 0){		
		$start = $_POST['start'];

		if(isset($_POST['key']) && @$_POST['key'] != ""){
			$key = "%".$_POST['key']."%";
			if(isset($_POST['minharga']) && $_POST['minharga'] != ""){
				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$minharga = $_POST['minharga'];
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `aset` WHERE (nama LIKE ?) AND harga_perolehan >= ? AND harga_perolehan <= ? AND id_pemilik = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("siiii",$key,$minharga,$maxharga,$id_pemilik,$start);
				}
				else{
					$minharga = $_POST['minharga'];
					$query = "SELECT * FROM `aset` WHERE (nama LIKE ?) AND harga_perolehan >= ? AND id_pemilik = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("siii",$key,$minharga,$id_pemilik,$start);	
				}
			}
			else{
				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `aset` WHERE (nama LIKE ?) AND  harga_perolehan <= ? AND id_pemilik = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("siii",$key,$maxharga,$id_pemilik,$start);
				}
				else{
				
					$query = "SELECT * FROM `aset` WHERE nama LIKE ? AND id_pemilik = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("sii",$key,$id_pemilik,$start);	
				}
			}
		}
		else{
			if(isset($_POST['minharga']) && $_POST['minharga'] != ""){

				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$minharga = $_POST['minharga'];
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `aset` WHERE harga_perolehan >= ? AND harga_perolehan <= ? AND id_pemilik = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("iiii",$minharga,$maxharga,$id_pemilik,$start);
				}
				else{
					$minharga = $_POST['minharga'];
					$query = "SELECT * FROM `aset` WHERE harga_perolehan >= ? AND id_pemilik = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("iii",$minharga,$id_pemilik,$start);	
				}
			}
			else{
				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `aset` WHERE harga_perolehan <= ? AND id_pemilik = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("iii",$maxharga,$id_pemilik,$start);
				}
				else{
					$query = "SELECT * FROM `aset` WHERE id_pemilik = ? limit ?,$banyakindex";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("ii",$id_pemilik,$start);
				}
			}
		}
		$result = $exquery->execute();
		if($result){
			$html = "";
			$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
			for($i=0;$i<count($hasil);$i++){
				$html .= "<tr>
						<td style=\"font-size: large; font-weight: bold;\">".$hasil[$i]['id']."</td>
						<td style=\"font-size: large; font-weight: bold;\">".$hasil[$i]['nama']."</td>";
				if($hasil[$i]['gambar'] != ''){
					$tglbeli = date_create(date("Y-m-d H:i:s",strtotime($hasil[$i]['tanggal_beli'])));
					$tglsekarang = date_create(date("Y-m-d H:i:s"));
					$diff  = date_diff( $tglbeli, $tglsekarang );
					$jumlahumur = $hasil[$i]['harga_perolehan']-($diff->y+($diff->m)/12+($diff->d)/365)*($hasil[$i]['harga_perolehan']-$hasil[$i]['harga_sisa'])/$hasil[$i]['umur'];
					$harga_sekarang = $hasil[$i]['harga_perolehan']-($diff->y+($diff->m)/12+($diff->d)/365)*($hasil[$i]['harga_perolehan']-$hasil[$i]['harga_sisa'])/$hasil[$i]['umur'];
					$total_biaya_penyusutan_per_hari = ($hasil[$i]['harga_perolehan']-$harga_sekarang)/365;
					//$total_biaya_penyusutan_per_hari = ($hasil[$i]['harga_perolehan']-$harga_sekarang)/365+$hasil[$i]['harga_perolehan']/($diff->y+($diff->m)/12+($diff->d)/365)/365;
					$html .= "<td><a href='../../../images/".$hasil[$i]['gambar']."'  onclick='return hs.expand(this)' class='highslide'><img src='../../../images/".$hasil[$i]['gambar']."' width=120px height=120px ></a></td>
					<td style=\"font-size: small; font-weight: bold;\">".rupiah($hasil[$i]['harga_perolehan'])."</td>
					<td style=\"font-size: small; font-weight: bold;\">".$hasil[$i]['umur']."</td>
					<td style=\"font-size: small; font-weight: bold;\">".rupiah($hasil[$i]['harga_sisa'])."</td>
					<td style=\"font-size: small; font-weight: bold;\">".$hasil[$i]['tanggal_beli']."</td>
					<td style=\"font-size: small; font-weight: bold;\">".rupiah(($hasil[$i]['harga_perolehan']-$hasil[$i]['harga_sisa'])/$hasil[$i]['umur'])."</td>
					<td style=\"font-size: small; font-weight: bold;\">".rupiah($jumlahumur)."</td>
					<td style=\"font-size: small; font-weight: bold;\">".rupiah($total_biaya_penyusutan_per_hari)."</td>
					<td>
						<select id='Aksi".$hasil[$i]['id']."' name='Aksi".$hasil[$i]['id']."' onChange=document.getElementById('Aksi".$hasil[$i]['id']."').name='Aksi';document.getElementById('identitas').value='".$hasil[$i]['id']."';document.getElementById('daftar').submit() >
							<option value=''>--pilih aksi--</option>
							<option value='salin'>Salin</option>
							<option value='edit'>Edit</option>
							<option value='hapus'>Hapus</option>
						</select>
					</td></tr>";
				}
				else{
					$tglbeli = date_create(date("Y-m-d H:i:s",strtotime($hasil[$i]['tanggal_beli'])));
					$tglsekarang = date_create(date("Y-m-d H:i:s"));
					$diff  = date_diff( $tglbeli, $tglsekarang );
					$jumlahumur = $hasil[$i]['harga_perolehan']-($diff->y+($diff->m)/12+($diff->d)/365)*($hasil[$i]['harga_perolehan']-$hasil[$i]['harga_sisa'])/$hasil[$i]['umur'];
					$harga_sekarang = $hasil[$i]['harga_perolehan']-($diff->y+($diff->m)/12+($diff->d)/365)*($hasil[$i]['harga_perolehan']-$hasil[$i]['harga_sisa'])/$hasil[$i]['umur'];
					$total_biaya_penyusutan_per_hari = ($hasil[$i]['harga_perolehan']-$harga_sekarang)/365;
					//$total_biaya_penyusutan_per_hari = ($hasil[$i]['harga_perolehan']-$harga_sekarang)/365+$hasil[$i]['harga_perolehan']/($diff->y+($diff->m)/12+($diff->d)/365)/365;
					$html .= "<td></td>
					<td style=\"font-size: small; font-weight: bold;\">".rupiah($hasil[$i]['harga_perolehan'])."</td>
					<td style=\"font-size: small; font-weight: bold;\">".$hasil[$i]['umur']."</td>
					<td style=\"font-size: small; font-weight: bold;\">".rupiah($hasil[$i]['harga_sisa'])."</td>
					<td style=\"font-size: small; font-weight: bold;\">".$hasil[$i]['tanggal_beli']."</td>
					<td style=\"font-size: small; font-weight: bold;\">".rupiah(($hasil[$i]['harga_perolehan']-$hasil[$i]['harga_sisa'])/$hasil[$i]['umur'])."</td>
					<td style=\"font-size: small; font-weight: bold;\">".rupiah($jumlahumur)."</td>
					<td style=\"font-size: small; font-weight: bold;\">".rupiah($total_biaya_penyusutan_per_hari)."</td>
					<td>
						<select id='Aksi".$hasil[$i]['id']."' name='Aksi".$hasil[$i]['id']."' onChange=document.getElementById('Aksi".$hasil[$i]['id']."').name='Aksi';document.getElementById('identitas').value='".$hasil[$i]['id']."';document.getElementById('daftar').submit() >
							<option value=''>--pilih aksi--</option>
							<option value='salin'>Salin</option>
							<option value='edit'>Edit</option>
							<option value='hapus'>Hapus</option>
						</select>
					</td>
					</tr>";
				}
			}
			echo $html;
		}
	}
?>