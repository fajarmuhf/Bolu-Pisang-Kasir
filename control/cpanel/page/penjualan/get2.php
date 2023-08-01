<?php
	session_start();
	include "../secure.php";

	include "../../../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
	$banyakindex = 7;

	function rupiah($angka){
	
		$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
		return $hasil_rupiah;
	 
	}
				
	if(isset($_POST['start']) && @$_POST['start'] >= 0){
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
		$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("ss",$username,$password);
		$exquery->execute();
		$tanggal = date("Y-m-d H:i:s");
		if($exquery){
			$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

			$iduser = $tampil[0]["Id"];
		}

		$start = $_POST['start'];		
		$query = "SELECT * FROM `notif` WHERE 1 ORDER BY tanggal DESC limit ?,$banyakindex ";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("i",$start);
		$result = $exquery->execute();
		if($result){
			$html = "";
			$totalbayar = 0;
			$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
			for($i=0;$i<count($hasil);$i++){
				$html .= "<tr>
					<td style=\"font-size: small; font-weight: bold;\">
						".$hasil[$i]['tanggal']."<br><br>
						".$hasil[$i]['message']."<br>
					</td>";
						
				/*$html .= "
				<td>
					<select id='Aksi".$hasil[$i]['id']."' name='Aksi".$hasil[$i]['id']."' onChange=document.getElementById('Aksi".$hasil[$i]['id']."').name='Aksi';document.getElementById('identitas').value='".$hasil[$i]['id']."';document.getElementById('daftar').submit() >
						<option value=''>--pilih aksi--</option>
						<option value='hapus'>Hapus</option>
					</select>
				</td>
				</tr>";*/
			
			}
			echo $html;
		}
	}
?>