<?php
	session_start();
	if(isset($_SESSION["username"]) && isset($_SESSION['password']) && isset($_SESSION['status'])){
		if($_SESSION['status'] == 'admin'){
			echo "<script>window.location='cpanel/admin.php'</script>";
		}
		else if($_SESSION['status'] == 'user'){
			echo "<script>window.location='cpanel/user.php'</script>";
		}
	}
?>
<!DOCTYPE HTML>
<head>
	<title><?php 
				include "include/koneksi.php";
				$Koneksi = new Hubungi();
				echo $Koneksi->getJudul();
			?></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
	<link rel="stylesheet" href="style.css" >
</head>
<body>
	<header class="header">
		<section class="flex">
			<a href="index.php" class="logo"><?php echo $Koneksi->getJudul(); ?></a>
			<nav class="navbar">
				<a href="index.php">Home</a>
				<a href="login.php">Login</a>
				<a href="about.php">About</a>
			</nav>
		</section>
	</header>
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
				include "include/user.php";
				
				if(@$_GET["Login"] == 1){
					if(@$_POST["username"] != "" && @$_POST["password"] != ""){
						$Koneksi->Konek("fandystore");
							
						$username = $_POST["username"];
						$password = md5($_POST["password"]);
							
						$userbaru = new User();
						$userbaru->setUsername($username);
						$userbaru->setPassword(md5($password));
							
						$query="SELECT COUNT(*),Status FROM `user-manager` WHERE Username = ? AND Password = ?";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$username,$password);
						$exquery->execute();
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
							if($tampil[0]['COUNT(*)'] > 0){
								$_SESSION["username"]=$_POST["username"];
								$_SESSION["password"]=md5($_POST["password"]);
								$_SESSION["status"]=$tampil[0]['Status'];
								if($tampil[0]['Status'] == 'admin'){
									echo "<script>window.location='cpanel/admin.php'</script>";
								}
								else if($tampil[0]['Status'] == 'kasir'){
									echo "<script>window.location='cpanel/kasir.php'</script>";
								}
							}
							else{
								echo "Maaf Username atau Password salah";
							}
						}
						else{
							echo "Maaf Username atau Password salah";
						}
						$exquery->close();
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
