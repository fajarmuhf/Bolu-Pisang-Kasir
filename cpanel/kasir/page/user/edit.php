		<form action="?page=user&i=edit&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Edit</td>
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
				<td>Username : </td><td><input type="text" name="username" id="username"></td>
			</tr>
			<tr>
				<td>Password : </td><td><input type="text" name="password" id="password"></td>
			</tr>
			<tr>
				<td>Status : </td><td><input type="text" name="status" id="status"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Edit </button></td>
			</tr>
			</table>
			<?php
				include "include/koneksi.php";
				include "include/user.php";
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["username"] != "" && @$_POST["password"] != "" && @$_POST["status"] != "" &&
					@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("penjualan_mobil");
								
						$username = $_POST["username"];
						$password = $_POST["password"];
						$status = $_POST["status"];
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
								
						$ob1 = new User();
						$ob1->setUsername($username);
						$ob1->setPassword($password);
						$ob1->setStatus($status);
						
						$query = "SELECT COUNT(*) From User WHERE UPPER($atribut) = UPPER('$nilai')";
						$exquery = mysql_query($query);
						if($exquery){		
							$hasil = mysql_fetch_array($exquery);
							if($hasil[0] > 0){
								$query2 = "UPDATE `User` SET Username = '".$ob1->getUsername()."',Password = '".$ob1->getPassword()."',Status = '".$ob1->getStatus()."' WHERE $atribut = '$nilai' ";
								$exquery2 = mysql_query($query2);
								if($exquery2){
									echo "Anda telah berhasil mengedit data<br>";
								}
								else{
									echo "Anda tidak berhasil mengedit data<br>";
								}
							}
							else{
								echo "Anda tidak berhasil mengedit data<br>";
							}
						}
						else{
							echo "Anda tidak berhasil mengedit data<br>";
						}
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
