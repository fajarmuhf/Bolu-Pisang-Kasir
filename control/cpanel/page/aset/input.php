		<form action="?page=aset&i=input&kirim=1" method="post" enctype="multipart/form-data">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Tambah</td>
			</tr>
			<tr>
				<td>Nama : </td><td><input type="text" name="nama" id="nama"></td>
			</tr>
			<tr>
				<td>Gambar : </td><td><input type="file" name="gambar" id="gambar"></td>
			</tr>
			<tr>
				<td>Harga Perolehan : </td><td><input type="number" name="hargaperolehan" id="hargaperolehan"></td>
			</tr>
			<tr>
				<td>Umur : </td><td><input type="number" name="umur" id="umur"></td>
			</tr>
			<tr>
				<td>Harga Sisa : </td><td><input type="number" name="hargasisa" id="hargasisa"></td>
			</tr>
			<tr>
				<td>Tanggal Beli : </td><td><input type="date" name="tanggalbeli" id="tanggalbeli"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/barang.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["nama"] != "" && @$_POST["hargaperolehan"] != "" && @$_POST["umur"] && @$_POST["hargasisa"] != "" && @$_POST["tanggalbeli"] != "" && @$_FILES["gambar"]["error"] <= 0){
						$Koneksi->Konek("fandystore");

						$kueh = "SELECT Id FROM `user-manager` WHERE Username = '".$_SESSION['username']."'";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							$hasilkueh = mysqli_fetch_array($exkueh);
							$id_pemilik = $hasilkueh["Id"];
						}

						$kueh = "SELECT (COUNT(*)+1) FROM `aset` WHERE 1 ";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							$hasilkueh = mysqli_fetch_array($exkueh);
							$nama = $_POST["nama"];
							$hargaperolehan = $_POST["hargaperolehan"];
							$umur = $_POST["umur"];
							$hargasisa = $_POST["hargasisa"];
							$tanggalbeli = $_POST["tanggalbeli"];
							$tanggalbeli = date("Y-m-d", strtotime($tanggalbeli));
							$gambar = $_FILES["gambar"]["name"];
								
							 if (file_exists("../../../images/" . $hasilkueh[0]."-".$id_pemilik."-".$gambar))
							 {
								echo $hasilkueh[0]."-".$id_pemilik."-".$gambar . " already exists. ";
							 }
							 else
							 {
								move_uploaded_file($_FILES["gambar"]["tmp_name"],"../../../images/" . $hasilkueh[0]."-".$id_pemilik."-".$gambar);
								$namagambar = $hasilkueh[0]."-".$id_pemilik."-".$gambar;							
								$query = "INSERT INTO `aset` SELECT (COUNT(*)+1),?,?,?,?,?,?,? FROM `aset` WHERE 1 ";
								$exquery=$Koneksi->getKonek()->prepare($query);
								$exquery->bind_param("issiiis",$id_pemilik,$nama,$namagambar,$hargaperolehan,$umur,$hargasisa,$tanggalbeli);
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
