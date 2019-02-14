<!DOCTYPE HTML>
<head>
	<title>Perusahaan Bolu Pisang</title>
	<link rel="stylesheet" href="style.css" >
</head>
<body>
	<header>
		<h2>Perusahaan Bolu Pisang</h2>
	</header>
	<nav>
		<ul>
			<li class="puter"><a href="index.php">Home</a></li>
			<li class="puter"><a href="login.php">Login</a></li>
			<li class="puter"><a href="register.php">Register</a></li>
			<li class="puter"><a href="about.php">About</a></li>
		</ul>
	</nav>
	<article>
		<form action="?kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Register</td>
			</tr>
			<tr>
				<td>Username : </td><td><input type="text" name="username" id="username"></td>
			</tr>
			<tr>
				<td>Password : </td><td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
				<td>Verify Password : </td><td><input type="password" name="vpassword" id="vpassword"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Register </button></td>
			</tr>
			</table>
			<?php
				include "include/koneksi.php";
				include "include/user.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["username"] != "" && @$_POST["password"] != ""){
						if(@$_POST["password"] == @$_POST["vpassword"]){
							$Koneksi = new Hubungi();
							$Koneksi->Konek("bolu_pisang");
							
							$username = $_POST["username"];
							$password = $_POST["password"];
							
							$userbaru = new User();
							$userbaru->setUsername($username);
							$userbaru->setPassword($password);
							
							$query = "INSERT INTO `User` SELECT (COUNT(*)+1),'".$userbaru->getUsername()."','".$userbaru->getPassword()."','user' FROM `User` WHERE (SELECT COUNT(*) From User WHERE UPPER(Username) = UPPER('".$userbaru->getUsername()."')) = 0 ";
							$exquery = mysql_query($query);
							if($exquery){
								echo "Anda telah berhasil mendaftar<br>";
							}
							else{
								echo "Anda tidak berhasil mendaftar<br>";
							}
							mysql_close($Koneksi->getKonek());
						}
						else{
							echo "Password validasi tidak sama<br>";
						}
					}
					else{
						echo "Data diisi terlebih dahulu";
					}
				}
			?>
		</form>
	</article>
	<footer>
		<small>&copy; 2013 Fajar Muhammad F</small>
	</footer>
</body>
</html>
