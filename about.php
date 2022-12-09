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
	<nav>
		<ul>
			<li class="puter"><a href="index.php">Home</a></li>
			<li class="puter"><a href="login.php">Login</a></li>
			<li class="puter"><a href="register.php">Register</a></li>
			<li class="puter"><a href="about.php">About</a></li>
		</ul>
	</nav>
	<article>
		<p class=about>Program Ini dibuat oleh Fajar Muhammad F</p>
	</article>
	<footer>
		<small>&copy; 2013 Fajar Muhammad F</small>
	</footer>
</body>
</html>
