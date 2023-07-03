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
	<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0,  minimum-scale=1"/> 
	<title><?php 
				include "include/koneksi.php";
				$Koneksi = new Hubungi();
				echo $Koneksi->getJudul();
			?></title>
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui.js"></script>
	<link rel="stylesheet" href="style.css" >
	<link rel="stylesheet" href="css/jquery-ui.css" >
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    
</head>
<body>
	<header class="header">
		<section class="flex">
			<a href="index.php" class="logo"><?php echo $Koneksi->getJudul(); ?></a>
			<nav class="navbar">
				<a href="index.php">Home</a>
				<a href="register.php">Register</a>
				<a href="about.php">About</a>
			</nav>
			<div class="icons">
	         <div id="menu-btn" class="fas fa-bars"></div>
	        </div>
		</section>
	</header>
	<article>
		<div style="flex: 1 1 100rem;">
			<div style="width:100%;margin: auto;">
				<form action="login.php?Login=1" method="post">
					<table class=Login style="width:20%">
					<tr>
						<td colspan=2>Login</td>
					</tr>
					<tr>
						<td>Username : </td><td><input type="text" name="username" id="username"></td>
					</tr>
					<tr>
						<td>Password : </td><td><input type="password" name="password" id="password"></td>
					</tr>
					<tr>
						<td colspan=2><button class="button"> Login </button></td>
					</tr>
					</table>
				</form>
			</div>
		</div>
	</article>
	<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

	<!-- custom js file link  -->
	<script src="js/script.js"></script>

	<script>

	var swiper = new Swiper(".hero-slider", {
	   loop:true,
	   grabCursor: true,
	   effect: "flip",
	   pagination: {
	      el: ".swiper-pagination",
	      clickable:true,
	   },
	});

	</script>
	<footer>
		<small>&copy; 2013 Fajar Muhammad F</small>
	</footer>
</body>
</html>
