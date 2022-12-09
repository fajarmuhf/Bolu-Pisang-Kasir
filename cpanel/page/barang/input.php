		<form action="?page=barang&i=input&kirim=1" method="post" enctype="multipart/form-data">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Tambah</td>
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
				<td>Gambar : </td><td><input type="file" name="gambar" id="gambar"></td>
			</tr>
			<tr>
				<td>Expire : </td><td><input type="date" name="expire" id="expire"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/barang.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["nama"] != "" && @$_POST["harga"] != "" && @$_POST["satuan"] && @$_POST["modal"] != "" && @$_POST["perum"] != "" && @$_POST["tag"] != "" && @$_POST["expire"] != ""   && @$_FILES["gambar"]["error"] <= 0){
						$Koneksi->Konek("fandystore");
						$kueh = "SELECT (COUNT(*)+1) FROM `produk` WHERE 1 ";
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
							$expire = $_POST["expire"];
							$expire = date("Y-m-d", strtotime($expire));
							$gambar = $_FILES["gambar"]["name"];
									
							$barangbaru = new Barang();
							$barangbaru->setNama($nama);
							$barangbaru->setHarga($harga);
							$barangbaru->setGambar($gambar);
								
							 if (file_exists("../../images/" . $_FILES["gambar"]["name"]))
							 {
								echo $barangbaru->getGambar() . " already exists. ";
							 }
							 else
							 {
								move_uploaded_file($_FILES["gambar"]["tmp_name"],"../../images/" . $barangbaru->getGambar());							
								$query = "INSERT INTO `produk` SELECT (COUNT(*)+1),?,?,?,?,?,?,?,?,0,?,? FROM `produk` WHERE 1 ";
								$exquery=$Koneksi->getKonek()->prepare($query);
								$exquery->bind_param("ssisiissss",$nama,$deskripsi,$stok,$satuan,$modal,$harga,$perum,$tag,$gambar,$expire);
								$result = $exquery->execute();
								if($result){
									echo "Anda telah berhasil menginput data<br>";
								}
								else{
									echo "Anda tidak berhasil menginput data<br>";
								}
							 }
						}
						else{
							echo "Anda tidak berhasil menginput data<br>";
						}			
						mysqli_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
