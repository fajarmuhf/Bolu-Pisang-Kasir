		<?php
			include "page/secure.php";
		?>
		<form action="?page=user&i=edit&kirim=1" method="post" enctype="multipart/form-data">
			<input type="hidden" name="atribut" id="atribut" value="id">
			<input type="hidden" name="nilai" id="nilai">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Edit</td>
			</tr>
			<tr>
				<td>Username : </td><td><input type="text" name="username" id="username"></td>
			</tr>
			<tr>
				<td>Password : </td><td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
				<td>Status : </td><td><select name="status" id="status">
					<option value="admin">admin</option>
					<option value="manager">manager</option>
					<option value="kasir">kasir</option>
				</select></td>
			</tr>
			<tr>
				<td>Perumahan : </td><td><select name="perum" id="perum">
					<?php
						$Koneksi->Konek("fandystore");
						$kueh = "SELECT * FROM `perumahan` WHERE 1 ";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							while($hasilkueh = mysqli_fetch_array($exkueh)){
								$perumahan = $hasilkueh["nama"];
								echo "<option value='$perumahan'>$perumahan</option>";
							}
						}
					?>
				</select></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Edit </button></td>
			</tr>
			</table>
			<?php
				include "include/user.php";
				$Koneksi->Konek("fandystore");
				
				if(isset($_GET['id'])){
					$kueh = "SELECT * FROM `user-manager` WHERE Id = ".$_GET['id'];
					$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
					if($exkueh){
						while($hasil = mysqli_fetch_array($exkueh)){
							echo "<script>";
							echo "document.getElementById('username').value='".$hasil['Username']."';";
							echo "document.getElementById('status').value='".$hasil['Status']."';";
							echo "document.getElementById('perum').value='".$hasil['Perum']."';";
							echo "</script>";
						}
					}
				}

				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["username"] != "" && @$_POST["password"] != "" && @$_POST["status"] != ""  && @$_POST["perum"] != "" &&
					@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("fandystore");
						
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
						
						$kueh = "SELECT * FROM `user-manager` WHERE Id = ?";
						$exquery=$Koneksi->getKonek()->prepare($kueh);
						$exquery->bind_param("i",$nilai);
						$result = $exquery->execute();

						if($result){
							$hasil = $exquery->get_result()->fetch_all(MYSQLI_ASSOC);
							if(true){
								$kueh2 = "SELECT Id FROM `user-manager` WHERE Id = ? ";
								$exquery2=$Koneksi->getKonek()->prepare($kueh2);
								$exquery2->bind_param("i",$nilai);
								$result2 = $exquery2->execute();
								if($result2){
									$hasilkueh = $exquery2->get_result()->fetch_all(MYSQLI_ASSOC);
									$username = $_POST["username"];
									$password = md5($_POST["password"]);
									$status = $_POST["status"];
									$perum = $_POST["perum"];
															
									$query = "UPDATE `user-manager` SET Username = ?,Password = ?,Status = ?,Perum = ? WHERE id = ? ";
									$exquery=$Koneksi->getKonek()->prepare($query);
									$exquery->bind_param("ssssi",$username,$password,$status,$perum,$nilai);
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
