<?php
	include "page/secure.php";			
?>
		<form action="?page=barang&i=edit&kirim=1" method="post" enctype="multipart/form-data">
			<input type="hidden" name="atribut" id="atribut" value="id">
			<input type="hidden" name="nilai" id="nilai">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Edit</td>
			</tr>
			<tr>
				<td>Nama : </td><td><input type="text" name="nama" id="nama"></td>
			</tr>
			<tr>
				<td>Deskripsi : </td><td><textarea type="text" name="deskripsi" id="deskripsi"></textarea></td>
			</tr>
			<tr>
				<td>Stok : </td><td><input type="number" name="stok" id="stok"></td>
			</tr>
			<tr>
				<td>Satuan : </td><td><input type="text" name="satuan" id="satuan"></td>
			</tr>
			<tr>
				<td>Modal : </td><td><input type="text" name="modal" id="modal"></td>
			</tr>
			<tr>
				<td>Harga : </td><td><input type="number" name="harga" id="harga"></td>
			</tr>
			<tr>
				<td>Perum : </td><td><input type="text" name="perum" id="perum"></td>
			</tr>
			<tr>
				<td>Tag : </td><td><input type="text" name="tag" id="tag"></td>
			</tr>
			<tr>
				<td>Jumlah Klik : </td><td><input type="number" name="jumlahklik" id="jumlahklik"></td>
			</tr>
			<tr>
				<td>Gambar : </td><td><input type="file" name="gambar" id="gambar"></td>
			</tr>
			<tr>
				<td>Expire : </td><td><input type="date" name="expire" id="expire"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Edit </button></td>
			</tr>
			</table>
			<?php
				include "include/barang.php";
				$Koneksi->Konek("fandystore");
				
				if(isset($_GET['id'])){
					$kueh = "SELECT * FROM produk WHERE id = ".$_GET['id'];
					$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
					if($exkueh){
						while($hasil = mysqli_fetch_array($exkueh)){
							echo "<script>";
							echo "document.getElementById('nama').value='".$hasil['nama']."';";
							echo "document.getElementById('deskripsi').innerHTML='".$hasil['deskripsi']."';";
							echo "document.getElementById('stok').value=".$hasil['stock'].";";
							echo "document.getElementById('satuan').value='".$hasil['satuan']."';";
							echo "document.getElementById('modal').value=".$hasil['modal'].";";
							echo "document.getElementById('harga').value=".$hasil['harga'].";";
							echo "document.getElementById('perum').value='".$hasil['perum']."';";
							echo "document.getElementById('tag').value='".$hasil['tag']."';";
							echo "document.getElementById('jumlahklik').value=".$hasil['jumlahklik'].";";
							echo "document.getElementById('expire').value='".$hasil['expdate']."';";
							echo "</script>";
						}
					}
				}

				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["nama"] != "" && @$_POST["harga"] != "" && @$_POST["satuan"] != "" && @$_POST["perum"] != "" && @$_POST["tag"] != "" && @$_POST["expire"] != "" &&
					@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("fandystore");
						
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
						
						$kueh = "SELECT * FROM produk WHERE $atribut = $nilai";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							while($hasil = mysqli_fetch_array($exkueh)){
								
								$kueh = "SELECT Id FROM `produk` WHERE $atribut = $nilai ";
								$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
								if($exkueh){
									$hasilkueh = mysqli_fetch_array($exkueh);
									$nama = $_POST["nama"];
									$deskripsi = $_POST["deskripsi"];
									$stok = $_POST["stok"];
									$satuan = $_POST["satuan"];
									$modal = $_POST["modal"];
									$harga = $_POST["harga"];
									$perum = $_POST["perum"];
									$tag = $_POST["tag"];
									$jumlahklik = $_POST["jumlahklik"];
									$expire = $_POST["expire"];
									$expire = date("Y-m-d", strtotime($expire));
									if(isset($_FILES["gambar"]) && @$_FILES["gambar"]["size"] > 0){
										$gambar = $_FILES["gambar"]["name"];
									}
									
									$mobilbaru = new Barang();
									$mobilbaru->setNama($nama);
									$mobilbaru->setHarga($harga);
										
									 if (isset($_FILES["gambar"]) && @$_FILES["gambar"]["size"] > 0 && file_exists("../../images/" . @$_FILES["gambar"]["name"]))
									 {
										echo $gambar . " already exists. ";
									 }
									 else
									 {
									 	if(isset($_FILES["gambar"]) && @$_FILES["gambar"]["size"] > 0){
										 	if ($hasil['imageurl'] != ""){
												unlink("../../images/".$hasil['imageurl']);
											}
											move_uploaded_file($_FILES["gambar"]["tmp_name"],"../../images/" . $gambar);							
											$query = "UPDATE `produk` SET nama = ?,deskripsi = ?,stock = ?,satuan = ?,modal = ?,harga = ?,perum = ?,tag = ?,jumlahklik = ?,imageurl = ?,expdate = ? WHERE id = ? ";
											$exquery=$Koneksi->getKonek()->prepare($query);
											$exquery->bind_param("ssisiississi",$nama,$deskripsi,$stok,$satuan,$modal,$harga,$perum,$tag,$jumlahklik,$gambar,$expire,$nilai);
										}
										else{
											$query = "UPDATE `produk` SET nama = ?,deskripsi = ?,stock = ?,satuan = ?,modal = ?,harga = ?,perum = ?,tag = ?,jumlahklik = ?,expdate = ? WHERE id = ? ";
											$exquery=$Koneksi->getKonek()->prepare($query);
											$exquery->bind_param("ssisiissisi",$nama,$deskripsi,$stok,$satuan,$modal,$harga,$perum,$tag,$jumlahklik,$expire,$nilai);
										}
										$result = $exquery->execute();
										if($result){
											echo "Anda telah berhasil mengedit data<br>";
										}
										else{
											echo "Anda tidak berhasil mengedit data<br>";
										}
									 }
								}
								else{
									echo "Anda tidak berhasil menginput data<br>";
								}
							}
						}
						mysqli_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
