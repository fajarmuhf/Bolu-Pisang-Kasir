<?php
	session_start();
	include "../secure.php";

	include "../../../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
	$banyakindex = 3;
				
	if(isset($_POST['start']) && @$_POST['start'] >= 0){		
		$start = $_POST['start'];		
		if(isset($_POST['key']) && @$_POST['key'] != ""){
			$key = "%".$_POST['key']."%";
			if(isset($_POST['minharga']) && $_POST['minharga'] != ""){

				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$minharga = $_POST['minharga'];
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `produk` WHERE (nama LIKE ? OR deskripsi LIKE ? OR tag LIKE ?) AND harga >= ? AND harga <= ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("sssiii",$key,$key,$key,$minharga,$maxharga,$start);
				}
				else{
					$minharga = $_POST['minharga'];
					$query = "SELECT * FROM `produk` WHERE (nama LIKE ? OR deskripsi LIKE ? OR tag LIKE ?) AND harga >= ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("sssii",$key,$key,$key,$minharga,$start);	
				}
			}
			else{
				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `produk` WHERE (nama LIKE ? OR deskripsi LIKE ? OR tag LIKE ?) AND  harga <= ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("sssii",$key,$key,$key,$maxharga,$start);
				}
				else{
				
					$query = "SELECT * FROM `produk` WHERE nama LIKE ? OR deskripsi LIKE ? OR tag LIKE ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("sssi",$key,$key,$key,$start);	
				}
			}
		}
		else{
			if(isset($_POST['minharga']) && $_POST['minharga'] != ""){

				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$minharga = $_POST['minharga'];
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `produk` WHERE harga >= ? AND harga <= ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("iii",$minharga,$maxharga,$start);
				}
				else{
					$minharga = $_POST['minharga'];
					$query = "SELECT * FROM `produk` WHERE harga >= ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("ii",$minharga,$start);	
				}
			}
			else{
				if(isset($_POST['maxharga']) && $_POST['maxharga'] != ""){
					$maxharga = $_POST['maxharga'];
					$query = "SELECT * FROM `produk` WHERE harga <= ? limit ?,$banyakindex ";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("ii",$maxharga,$start);
				}
				else{
					$query = "SELECT * FROM `produk` WHERE 1 limit ?,$banyakindex";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("i",$start);
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
						<td style=\"font-size: large; font-weight: bold;\">".$hasil[$i]['nama']."</td>
						<td style=\"font-size: small;\">".$hasil[$i]['deskripsi']."</td>
						<td style=\"font-size: large;\">".$hasil[$i]['stock']."</td>
						<td style=\"font-size: large;\">".$hasil[$i]['satuan']."</td>
						<td style=\"font-size: large;\">".$hasil[$i]['harga']."</td>
						<td style=\"font-size: large;\">".$hasil[$i]['perum']."</td>
						<td style=\"font-size: large;\">".$hasil[$i]['tag']."</td>";
				if($hasil[$i]['imageurl'] != ''){
					$html .= "<td><a href='../../images/".$hasil[$i]['imageurl']."'  onclick='return hs.expand(this)' class='highslide'><img src='../../images/".$hasil[$i]['imageurl']."' width=120px height=120px ></a></td>
					<td>".$hasil[$i]['expdate']."</td>
					<td>
						<input type=number id='banyak".$hasil[$i]['id']."' name='banyak".$hasil[$i]['id']."' placeholder='banyak item..' value=1>
						<select id='Aksi".$hasil[$i]['id']."' name='Aksi".$hasil[$i]['id']."' onChange=document.getElementById('Aksi".$hasil[$i]['id']."').name='Aksi';document.getElementById('identitas').value='".$hasil[$i]['id']."';document.getElementById('banyakitem').value=document.getElementById('banyak".$hasil[$i]['id']."').value;document.getElementById('daftar').submit() >
							<option value=''>--pilih aksi--</option>
							<option value='tambah'>Tambah Keranjang</option>
						</select>
					</td></tr>";
				}
				else{
					$html .= "<td></td>
					<td>
						<input type=number id='banyak".$hasil[$i]['id']."' name='banyak".$hasil[$i]['id']."' placeholder='banyak item..' value=1>
						<select id='Aksi".$hasil[$i]['id']."' name='Aksi".$hasil[$i]['id']."' onChange=document.getElementById('Aksi".$hasil[$i]['id']."').name='Aksi';document.getElementById('identitas').value='".$hasil[$i]['id']."';document.getElementById('banyakitem').value=document.getElementById('banyak".$hasil[$i]['id']."').value;document.getElementById('daftar').submit() >
							<option value=''>--pilih aksi--</option>
							<option value='tambah'>Tambah Keranjang</option>
						</select>
					</td>
					</tr>";
				}
			}
			echo $html;
		}
	}
?>