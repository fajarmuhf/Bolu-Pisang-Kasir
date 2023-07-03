<!DOCTYPE HTML>
<head>
	<title><?php 
				include "include/koneksi.php";
				$Koneksi = new Hubungi();
				echo $Koneksi->getJudul();
			?></title>
	<link rel="stylesheet" href="style.css" >
	<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0,  minimum-scale=1"/> 
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
		<p class=about>Program Ini dibuat oleh Fajar Muhammad F</p>
	</article>
	<footer>
		<small>&copy; 2013 Fajar Muhammad F</small>
	</footer>
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
</body>
</html>
