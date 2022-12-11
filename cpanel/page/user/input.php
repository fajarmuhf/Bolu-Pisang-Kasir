		<?php
			include "page/secure.php";
		?>
		<form action="?page=user&i=input&kirim=1" method="post" enctype="multipart/form-data">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Input</td>
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
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/user.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["username"] != "" && @$_POST["password"] != "" && @$_POST["status"] != "" && @$_POST["perum"] != ""){
						$kueh = "SELECT (COUNT(*)+1) FROM `user-manager` WHERE 1 ";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							$hasilkueh = mysqli_fetch_array($exkueh);
							$username = $_POST["username"];
							$password = md5($_POST["password"]);
							$status = $_POST["status"];
							$perum = $_POST["perum"];
								
							$query = "INSERT INTO `user-manager` SELECT (COUNT(*)+1),?,?,?,? FROM `user-manager` WHERE 1 ";
							$exquery=$Koneksi->getKonek()->prepare($query);
							$exquery->bind_param("ssss",$username,$password,$status,$perum);
							$result = $exquery->execute();
							if($result){
								echo "Anda telah berhasil menginput data<br>";
							}
							else{
								echo "Anda tidak berhasil menginput data<br>";
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
