<?php
	session_start();
	include "../../secure.php";

	include "../../../../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
	$banyakindex = 5;

	function rupiah($angka){
	
		$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
		return $hasil_rupiah;
	 
	}
				
	if(isset($_POST['start']) && @$_POST['start'] >= 0){		
		$start = $_POST['start'];	
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];

		$query2="SELECT Id,Perum FROM `user-manager` WHERE Username = ? AND Password = ?";
		$exquery2=$Koneksi->getKonek()->prepare($query2);
		$exquery2->bind_param("ss",$username,$password);
		$exquery2->execute();
		$tanggal = date("Y-m-d H:i:s");
		if($exquery2){
			$tampil2=$exquery2->get_result()->fetch_all(MYSQLI_ASSOC);

			$iduser = $tampil2[0]["Id"];
			$perum = $tampil2[0]["Perum"];
		}

		if(isset($_POST['key']) && @$_POST['key'] != ""){
			$key = "%".$_POST['key']."%";
			if(isset($_POST['minharga']) && $_POST['minharga'] != ""){

				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$minharga = $_POST['minharga'];
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `produk` WHERE (nama LIKE ? OR deskripsi LIKE ? OR tag LIKE ?) AND harga >= ? AND harga <= ? AND perum = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("sssiisi",$key,$key,$key,$minharga,$maxharga,$perum,$start);
				}
				else{
					$minharga = $_POST['minharga'];
					$query = "SELECT * FROM `produk` WHERE (nama LIKE ? OR deskripsi LIKE ? OR tag LIKE ?) AND harga >= ? AND perum = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("sssisi",$key,$key,$key,$minharga,$perum,$start);	
				}
			}
			else{
				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `produk` WHERE (nama LIKE ? OR deskripsi LIKE ? OR tag LIKE ?) AND  harga <= ? AND perum = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("sssisi",$key,$key,$key,$maxharga,$perum,$start);
				}
				else{
				
					$query = "SELECT * FROM `produk` WHERE (nama LIKE ? OR deskripsi LIKE ? OR tag LIKE ?) AND perum = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("ssssi",$key,$key,$key,$perum,$start);	
				}
			}
		}
		else{
			if(isset($_POST['minharga']) && $_POST['minharga'] != ""){

				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$minharga = $_POST['minharga'];
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `produk` WHERE harga >= ? AND harga <= ? AND perum = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("iisi",$minharga,$maxharga,$perum,$start);
				}
				else{
					$minharga = $_POST['minharga'];
					$query = "SELECT * FROM `produk` WHERE harga >= ? AND perum = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("isi",$minharga,$perum,$start);	
				}
			}
			else{
				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `produk` WHERE harga <= ? AND perum = ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("isi",$maxharga,$perum,$start);
				}
				else{
					$query = "SELECT * FROM `produk` WHERE perum = ? limit ?,$banyakindex";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("si",$perum,$start);
				}
			}
		}
		$result = $exquery->execute();
		if($result){
			$html = "";
			$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
			for($i=0;$i<count($hasil);$i++){
				$html .= "<tr>
						<td style=\"font-size: large; font-weight: bold;\">
						<input type=hidden id='banyak".$hasil[$i]['id']."' name='banyak".$hasil[$i]['id']."' placeholder='banyak item..' value=1>
						<a href='../images/".$hasil[$i]['imageurl']."'  onclick='return hs.expand(this)' class='highslide'><img src='../images/".$hasil[$i]['imageurl']."' width=120px height=120px ></a><br>
							".rupiah($hasil[$i]['harga'])."
							</td>
						<td>
							<select id='Aksi".$hasil[$i]['id']."' name='Aksi".$hasil[$i]['id']."' onChange='document.getElementById(\"Aksi".$hasil[$i]['id']."\").name=\"Aksi\";document.getElementById(\"identitas\").value=\"".$hasil[$i]['id']."\";document.getElementById(\"banyakitem\").value=document.getElementById(\"banyak".$hasil[$i]['id']."\").value;document.getElementById(\"daftar\").submit();' >
								<option value=''>--pilih aksi--</option>
								<option value='retur'>retur</option>
								<option value='kirim'>kirim</option>
							</select>
						</td>
						</tr>";
			}
			echo $html;
		}
	}
?>