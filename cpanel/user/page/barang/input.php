		<form action="?page=barang&i=input&kirim=1" method="post" enctype="multipart/form-data">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Input</td>
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
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/koneksi.php";
				include "include/barang.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["nama"] != "" && @$_POST["harga"] != "" && @$_POST["ket"] != "" && @$_FILES["gambar"]["error"] <= 0){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
						$kueh = "SELECT (COUNT(*)+1) FROM `Barang` WHERE 1 ";
						$exkueh = mysql_query($kueh);
						if($exkueh){
							$hasilkueh = mysql_fetch_array($exkueh);
							$nama = $_POST["nama"];
							$harga = $_POST["harga"];
							$ket = $_POST["ket"];
							$gambar = $hasilkueh[0]."_".$_FILES["gambar"]["name"];
									
							$barangbaru = new Barang();
							$barangbaru->setNama($nama);
							$barangbaru->setHarga($harga);
							$barangbaru->setKet($ket);
							$barangbaru->setGambar($gambar);
								
							 if (file_exists("upload/" . $_FILES["gambar"]["name"]))
							 {
								echo $barangbaru->getGambar() . " already exists. ";
							 }
							 else
							 {
								move_uploaded_file($_FILES["gambar"]["tmp_name"],"upload/" . $barangbaru->getGambar());							
								$query = "INSERT INTO `Barang` SELECT (COUNT(*)+1),'".$barangbaru->getNama()."','".$barangbaru->getHarga()."','".$barangbaru->getKet()."','".$barangbaru->getGambar()."' FROM `Barang` WHERE 1 ";
								$exquery = mysql_query($query);
								if($exquery){
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
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
