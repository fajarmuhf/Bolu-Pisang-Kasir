<?php
	session_start();
	include "../secure.php";

	include "../../../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
				
	if(isset($_POST['start']) && @$_POST['start'] >= 0){		
		$start = $_POST['start'];		
		if(isset($_POST['key']) && @$_POST['key'] != ""){
			$key = "%".$_POST['key']."%";
				
			$query = "SELECT * FROM `perumahan` WHERE nama LIKE ? OR lokasi LIKE ? limit ?,10";
			$exquery=$Koneksi->getKonek()->prepare($query);
			$exquery->bind_param("ssi",$key,$key,$start);	
		
		}
		else{
			$query = "SELECT * FROM `perumahan` WHERE 1 limit ?,10 ";
			$exquery=$Koneksi->getKonek()->prepare($query);
			$exquery->bind_param("i",$start);	
		}
		$result = $exquery->execute();
		if($result){
			$html = "";
			$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
			for($i=0;$i<count($hasil);$i++){
				$html .= "<tr>
						<td>".$hasil[$i]['id']."</td>
						<td>".$hasil[$i]['nama']."</td>
						<td>".$hasil[$i]['lokasi']."</td>";
				$html .= "
					<td>
						<select id='Aksi".$hasil[$i]['id']."' name='Aksi".$hasil[$i]['id']."' onChange=document.getElementById('Aksi".$hasil[$i]['id']."').name='Aksi';document.getElementById('identitas').value='".$hasil[$i]['id']."';document.getElementById('daftar').submit() >
							<option value=''>--pilih aksi--</option>
							<option value='edit'>Edit</option>
							<option value='hapus'>Hapus</option>
						</select>
					</td></tr>";
			}
			echo $html;
		}
	}
?>