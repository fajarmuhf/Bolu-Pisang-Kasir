<!DOCTYPE HTML>
<head>
	<title><?php 
				include "include/koneksi.php";
				$Koneksi = new Hubungi();
				echo $Koneksi->getJudul();
			?></title>
	<link rel="stylesheet" href="style.css" >
</head>
<body>
	<header>
		<h2><?php echo $Koneksi->getJudul(); ?></h2>
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
				include "include/user.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["username"] != "" && @$_POST["password"] != ""){
						if(@$_POST["password"] == @$_POST["vpassword"]){
							$Koneksi->Konek("fandystore");
							
							$username = $_POST["username"];
							$password = md5($_POST["password"]);
							
							$userbaru = new User();
							$userbaru->setUsername($username);
							$userbaru->setPassword($password);
							
							$query = "INSERT INTO `user-manager` SELECT (COUNT(*)+1),?,?,'admin' FROM `user-manager` WHERE (SELECT COUNT(*) From User WHERE UPPER(Username) = UPPER(?)) = 0 ";
							$exquery=$Koneksi->getKonek()->prepare($query);
							$exquery->bind_param("sss",$username,$password,$username);
							$tampil=$exquery->execute();
							if($tampil){
								echo "Anda telah berhasil mendaftar<br>";
							}
							else{
								echo "Anda tidak berhasil mendaftar<br>";
							}
							$exquery->close();
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
