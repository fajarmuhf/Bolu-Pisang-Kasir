		<form action="?page=perumahan&i=edit&kirim=1" method="post" enctype="multipart/form-data">
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
				<td>Lokasi : </td><td><input type="text" name="lokasi" id="lokasi"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Edit </button></td>
			</tr>
			</table>
			<?php
				include "include/user.php";
				$Koneksi->Konek("fandystore");
				
				if(isset($_GET['id'])){
					$kueh = "SELECT * FROM `perumahan` WHERE id = ".$_GET['id'];
					$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
					if($exkueh){
						while($hasil = mysqli_fetch_array($exkueh)){
							echo "<script>";
							echo "document.getElementById('nama').value='".$hasil['nama']."';";
							echo "document.getElementById('lokasi').value='".$hasil['lokasi']."';";
							echo "</script>";
						}
					}
				}

				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["nama"] != "" && @$_POST["lokasi"] != "" &&
					@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("fandystore");
						
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
						
						$kueh = "SELECT * FROM `perumahan` WHERE id = ?";
						$exquery=$Koneksi->getKonek()->prepare($kueh);
						$exquery->bind_param("i",$nilai);
						$result = $exquery->execute();

						if($result){
							$hasil = $exquery->get_result()->fetch_all(MYSQLI_ASSOC);
							if(true){
								$kueh2 = "SELECT Id FROM `perumahan` WHERE id = ? ";
								$exquery2=$Koneksi->getKonek()->prepare($kueh2);
								$exquery2->bind_param("i",$nilai);
								$result2 = $exquery2->execute();
								if($result2){
									$hasilkueh = $exquery2->get_result()->fetch_all(MYSQLI_ASSOC);
									$nama = $_POST["nama"];
									$lokasi = ($_POST["lokasi"]);
															
									$query = "UPDATE `perumahan` SET Nama = ?,Lokasi = ? WHERE id = ? ";
									$exquery=$Koneksi->getKonek()->prepare($query);
									$exquery->bind_param("ssi",$nama,$lokasi,$nilai);
									$result = $exquery->execute();
									if($result){
										echo "Anda telah berhasil mengedit data<br>";
									}
									else{
										echo "Anda tidak berhasil mengedit data<br>";
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
