		<form action="?page=barang&i=edit&kirim=1" method="post" enctype="multipart/form-data">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Edit</td>
			</tr>
			<tr>
				<td>Atribut : </td>
				<td>
					<select name="atribut" id="atribut">
						<option value="Id">Id</option>
						<option value="Nama">Nama</option>
						<option value="Keterangan">Keterangan</option>
						<option value="Tahun">Tahun</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Nilai : </td><td><input type="text" name="nilai" id="nilai"></td>
			</tr>
			<tr>
				<td>Nama : </td><td><input type="text" name="nama" id="nama"></td>
			</tr>
			<tr>
				<td>Harga : </td><td><input type="text" name="harga" id="harga"></td>
			</tr>
			<tr>
				<td>Keterangan : </td><td><input type="text" name="ket" id="ket"></td>
			</tr>
			<tr>
				<td>Gambar : </td><td><input type="file" name="gambar" id="gambar"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Edit </button></td>
			</tr>
			</table>
			<?php
				include "include/koneksi.php";
				include "include/barang.php";
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["nama"] != "" && @$_POST["harga"] != "" && @$_POST["ket"] != "" && @$_FILES["gambar"]["error"] <= 0 &&
					@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
						
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
						
						$kueh = "SELECT * FROM Barang WHERE $atribut = $nilai";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							while($hasil = mysqli_fetch_array($exkueh)){
								if ($hasil['Gambar'] != ""){
									unlink("upload/".$hasil['Gambar']);
								}
								$kueh = "SELECT Id FROM `Barang` WHERE $atribut = $nilai ";
								$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
								if($exkueh){
									$hasilkueh = mysqli_fetch_array($exkueh);
									$nama = $_POST["nama"];
									$harga = $_POST["harga"];
									$ket = $_POST["ket"];
									$gambar = $hasilkueh[0]."_".$_FILES["gambar"]["name"];
											
									$mobilbaru = new Barang();
									$mobilbaru->setNama($nama);
									$mobilbaru->setHarga($harga);
									$mobilbaru->setKet($ket);
									$mobilbaru->setGambar($gambar);
										
									 if (file_exists("upload/" . $_FILES["gambar"]["name"]))
									 {
										echo $mobilbaru->getGambar() . " already exists. ";
									 }
									 else
									 {
										move_uploaded_file($_FILES["gambar"]["tmp_name"],"upload/" . $mobilbaru->getGambar());							
										$query = "UPDATE `Barang` SET Nama = '".$mobilbaru->getNama()."',Harga = '".$mobilbaru->getHarga()."',Keterangan = '".$mobilbaru->getKet()."',Gambar = '".$mobilbaru->getGambar()."' WHERE $atribut = '$nilai' ";
										$exquery = mysqli_query($Koneksi->getKonek(),$query);
										if($exquery){
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
