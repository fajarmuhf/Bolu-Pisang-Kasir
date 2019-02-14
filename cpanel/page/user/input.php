		<form action="?page=user&i=input&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Input</td>
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
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/koneksi.php";
				include "include/user.php";
			
				if(@$_GET["kirim"] == 1){
					if(@$_POST["username"] != "" && @$_POST["password"] != "" && @$_POST["status"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$username = $_POST["username"];
						$password = $_POST["password"];
						$status = $_POST["status"];
								
						$ob1 = new User();
						$ob1->setUsername($username);
						$ob1->setPassword($password);
						$ob1->setStatus($status);
								
						$query = "INSERT INTO `User` SELECT (COUNT(*)+1),'".$ob1->getUsername()."','".md5($ob1->getPassword())."','".$ob1->getStatus()."' FROM `User` WHERE (SELECT COUNT(*) From User WHERE UPPER(Username) = UPPER('".$ob1->getUsername()."')) = 0  ";
						$exquery = mysqli_query($Koneksi->getKonek(),$query);
						if($exquery){
							echo "Anda telah berhasil menginput data<br>";
						}
						else{
							echo "Anda tidak berhasil menginput data<br>";
						}
						mysqli_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
