<?php
	session_start();
?>
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
		<form action="?Login=1" method="post">
			<table class=Login>
			<tr>
				<td colspan=2>Login</td>
			</tr>
			<tr>
				<td>NoHP : </td><td><input type="text" name="username" id="username"></td>
			</tr>
			<tr>
				<td>Password : </td><td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Login </button></td>
			</tr>
			</table>
			<?php
				include "include/koneksi.php";
				include "include/user.php";
				
				if(@$_GET["Login"] == 1){
					if(@$_POST["username"] != "" && @$_POST["password"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("Bolu");
							
						$username = $_POST["username"];
						$password = $_POST["password"];
							
						$userbaru = new User();
						$userbaru->setUsername($username);
						$userbaru->setPassword(md5($password));
							
						$query="SELECT COUNT(*),Status FROM User WHERE NoHP = '".$userbaru->getUsername()."' AND Password = '".$userbaru->getPassword()."'";
						$exquery=mysql_query($query);
						if($exquery){
							$tampil=mysql_fetch_array($exquery);
							if($tampil[0] > 0){
								$_SESSION["username"]=$_POST["username"];
								$_SESSION["password"]=md5($_POST["password"]);
								if($tampil[1] == 'admin'){
									echo "<script>window.location='cpanel/admin.php'</script>";
								}
								else if($tampil[1] == 'user'){
									echo "<script>window.location='cpanel/user.php'</script>";
								}
							}
							else{
								echo "Maaf Username atau Password salah";
							}
						}
						else{
							echo "Maaf Username atau Password salah";
						}
					}
					else{
						echo "Data disi terlebih dahulu";
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
