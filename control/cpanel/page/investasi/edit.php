<?php
	include "page/secure.php";			
?>
		<form action="?page=aset&i=edit&kirim=1" method="post" enctype="multipart/form-data">
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
				<td colspan=2><button class="button"> Edit </button></td>
			</tr>
			</table>
			<?php
				include "include/barang.php";
				$Koneksi->Konek("fandystore");
				
				if(isset($_GET['id'])){
					$kueh = "SELECT * FROM aset WHERE id = ".$_GET['id'];
					$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
					if($exkueh){
						while($hasil = mysqli_fetch_array($exkueh)){
							echo "<script>";
							echo "document.getElementById('nama').value='".$hasil['nama']."';";
							echo "document.getElementById('hargaperolehan').value='".$hasil['harga_perolehan']."';";
							echo "document.getElementById('umur').value=".$hasil['umur'].";";
							echo "document.getElementById('hargasisa').value='".$hasil['harga_sisa']."';";
							echo "document.getElementById('tanggalbeli').value='".date("Y-m-d", strtotime($hasil['tanggal_beli']))."';";
							echo "</script>";
						}
					}
				}

				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["nama"] != "" && @$_POST["hargaperolehan"] != "" && @$_POST["umur"] && @$_POST["hargasisa"] != "" && @$_POST["tanggalbeli"] != "" &&
					@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("fandystore");
						
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];

						$kueh = "SELECT Id FROM `user-manager` WHERE Username = '".$_SESSION['username']."'";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							$hasilkueh = mysqli_fetch_array($exkueh);
							$id_pemilik = $hasilkueh["Id"];
						}	
						
						$kueh = "SELECT * FROM aset WHERE $atribut = $nilai";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							while($hasil = mysqli_fetch_array($exkueh)){
								
								$kueh = "SELECT Id FROM `aset` WHERE $atribut = $nilai ";
								$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
								if($exkueh){
									$hasilkueh = mysqli_fetch_array($exkueh);
									$nama = $_POST["nama"];
									$hargaperolehan = $_POST["hargaperolehan"];
									$umur = $_POST["umur"];
									$hargasisa = $_POST["hargasisa"];
									$tanggalbeli = $_POST["tanggalbeli"];
									if(isset($_FILES["gambar"]) && @$_FILES["gambar"]["size"] > 0){
										$gambar = $_FILES["gambar"]["name"];
									}
										
									if (file_exists("../../images/" . $hasilkueh[0]."-".$id_pemilik."-".@$gambar))
									{
										echo $hasilkueh[0]."-".$id_pemilik."-".$gambar . " already exists. ";
									}
									else
									{
									 	if(isset($_FILES["gambar"]) && @$_FILES["gambar"]["size"] > 0){
										 	if ($hasil['gambar'] != ""){
												unlink("../../images/".$hasil['gambar']);
											}
											move_uploaded_file($_FILES["gambar"]["tmp_name"],"../../images/" . $hasilkueh[0]."-".$id_pemilik."-".$gambar);
											$namagambar = $hasilkueh[0]."-".$id_pemilik."-".$gambar;							
											$query = "UPDATE `aset` SET nama = ?,gambar = ?,harga_perolehan = ?,umur = ?,harga_sisa = ?,tanggal_beli = ? WHERE id = ? AND id_pemilik = ?";
											$exquery=$Koneksi->getKonek()->prepare($query);
											$exquery->bind_param("ssiiisii",$nama,$namagambar,$hargaperolehan,$umur,$hargasisa,$tanggalbeli,$nilai,$id_pemilik);
										}
										else{
											$query = "UPDATE `aset` SET nama = ?,harga_perolehan = ?,umur = ?,harga_sisa = ?,tanggal_beli = ? WHERE id = ? AND id_pemilik = ?";
											$exquery=$Koneksi->getKonek()->prepare($query);
											$exquery->bind_param("siiisii",$nama,$hargaperolehan,$umur,$hargasisa,$tanggalbeli,$nilai,$id_pemilik);
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
