		<form action="?page=user&i=delete&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Delete</td>
			</tr>
			<tr>
				<td>Atribut : </td>
				<td>
					<select name="atribut" id="atribut">
						<option value="Id">Id</option>
						<option value="Username">Username</option>
						<option value="Password">Password</option>
						<option value="Status">Status</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Nilai : </td><td><input type="text" name="nilai" id="nilai"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Hapus </button></td>
			</tr>
			</table>
			<?php
				include "include/koneksi.php";
				include "include/user.php";
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
								
						$query = "SELECT COUNT(*) FROM User WHERE $atribut = '$nilai' ";
						$exquery = mysqli_query($Koneksi->getKonek(),$query);
						if($exquery){
							$hasil = mysqli_fetch_array($exquery);
							if($hasil[0] > 0){
								$query2 = "SELECT * FROM User WHERE $atribut = '$nilai'";
								$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
								if($exquery2){
									$kueh = "DELETE FROM `User` WHERE $atribut = '$nilai' ";
									$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
									if($exkueh){
										while($hasil2 = mysqli_fetch_array($exquery2)){
											$query3 = "SELECT COUNT(*) FROM User WHERE Id > ".$hasil2['Id'];
											$exquery3 = mysqli_query($Koneksi->getKonek(),$query3);
											if($exquery3){
												$hitung = mysqli_fetch_array($exquery3);
												if($hitung[0] > 0){
													$query4 = "UPDATE User SET Id = (Id-1) WHERE Id > ".$hasil2['Id'];
													$exquery4 = mysqli_query($Koneksi->getKonek(),$query4);
													if($exquery4){
														echo "Anda telah berhasil menghapus data<br>";
													}
													else{
														echo "Anda tidak berhasil menghapus data<br>";
													}
												}
												else{
													echo "Anda telah berhasil menghapus data<br>";
												}
											}
										}
									}
									else{
										echo "Anda tidak berhasil menghapus data<br>";
									}
								}
								else{
									echo "Anda tidak berhasil menghapus data<br>";
								}
							}
							else{
								echo "Anda tidak berhasil menghapus data<br>";
							}
						}
						else{
							echo "Anda tidak berhasil menghapus data<br>";
						}
						mysqli_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
