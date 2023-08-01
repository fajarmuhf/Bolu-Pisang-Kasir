<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();

	include "page/secure.php";
	include "../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");

	if(!(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['status']))){
		if(isset($_COOKIE['token'])){
			$cookie = $_COOKIE['token'] ?? null;
			if($cookie && strstr($cookie, ":")){
				$parts = explode(":", $cookie);
				$token_key = $parts[0];
				$token_value = $parts[1];
				$expires = time() + ((60*60*24) * 7);

				setcookie("token",$token_key.':'.$token_value,$expires);

				$query2 = "select * from `user-manager` where token_key = ? AND token_value = ?";
				$exquery2=$Koneksi->getKonek()->prepare($query2);
				$exquery2->bind_param("ss",$token_key,$token_value);
				$exquery2->execute();

				if($exquery2){
					$tampil2=$exquery2->get_result()->fetch_all(MYSQLI_ASSOC);

					$_SESSION["username"]=$tampil2[0]["Username"];
					$_SESSION["password"]=($tampil2[0]["Password"]);
					$_SESSION["status"]=$tampil2[0]['Status'];

				}
			}
		}
	}

	if(isset($_SESSION['status'])){
		if(strcmp($_SESSION['status'],"kasir") == 0){
			header("location:kasir.php");
		}
	}
?>
<!DOCTYPE HTML>
<head>
	<title><?php 
				echo $Koneksi->getJudul();
			?></title>
	<meta name="viewport" content="width=device-width, user-scalable=yes,height=device-height, initial-scale=1.0,  minimum-scale=1"/> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../style.css" >
	<script src="../js/jquery-1.9.1.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<script src="../js/jquery-ui-timepicker-addon.js"></script>
	<script src="../js/sweetalert2.all.min.js"></script>
	<link rel="stylesheet" href="../css/jquery-ui.css" >
	<link rel="stylesheet" href="../css/sweetalert2.min.css" >
	<link rel="stylesheet" href="../js/jquery-ui-timepicker-addon.js">
	<script type="text/javascript" src="../js/simple-lightbox.jquery.min.js"></script>
	<script type="text/javascript" src="../highslide/highslide.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../highslide/highslide.css" />
	<script type="text/javascript" src="../js/turn.min.js"></script>
	<style type="text/css">
		#magazine{
			width:576px;
			height:376px;
			margin-left:auto;
			margin-right:auto;
			margin-top:100px;
			postition:relatif;
		}
		#magazine .loader{
			background-image:url(../img/loader.gif);
			width:24px;
			height:24px;
			display:block;
			position:absolute;
			top:228px;
			left:188px;
		}
		#magazine .turn-page{
			background-color:#ccc;
			background-size:100% 100%;
		}
		#controls{		
			position:absolute;
			left:35%;
			top:120px;
			background-color:navy;
			float:left;
			width:100px;
			text-align:left;
			margin:5px 20px;
			padding:10px;
			font:11px arial;
			color:white;
			border-radius:20px;
			box-shadow:3px 3px 3px skyblue;
		}
		#controls2{
			position:absolute;
			left:50%;
			top:120px;
			background-color:navy;
			float:left;
			width:245px;
			text-align:left;
			margin:5px 0px;
			padding:2px;
			font:13px arial;
			color:white;
			border-radius:20px;
			box-shadow:3px 3px 3px skyblue;
		}

		#controls2 input, #controls2 label{
			font:13px arial;
		}

		#controls2 input{
			width:30px;
		}
		#page-number1{
			margin-top:10px;
		}
	</style>
	<script type="text/javascript">
		hs.graphicsDir = '../highslide/graphics/';
		hs.align = 'center';
		hs.transitions = ['expand', 'crossfade'];
		hs.outlineType = 'rounded-white';
		hs.wrapperClassName = 'controls-in-heading';
		hs.fadeInOut = true;
		hs.dimmingOpacity = 0.75;

		// Add the controlbar
		if (hs.addSlideshow) hs.addSlideshow({
			//slideshowGroup: 'group1',
			interval: 5000,
			repeat: false,
			useControls: false,
			fixedControls: false,
			overlayOptions: {
				opacity: 1,
				position: 'top right',
				hideOnMouseOut: true
			}
		});
	</script>
</head>
<body>
	<header class="header">
		<section class="flex">
			<a href="admin.php" class="logo"><?php
					echo $Koneksi->getJudul();
			?></a>
			<nav class="navbar">
				<a href="?page=penjualan">Laporan</a></li>
				<a href="?page=barang">Barang</a></li>
				<a href="?page=aset" >Aset</a></li>
				<a href="?page=perumahan">Perumahan</a></li>
				<a href="?page=user" >User</a></li>
				<a href="?page=driver" >Driver</a></li>
			</nav>
			<div class="icons">
	         <div id="menu-btn" class="fas fa-bars"></div>
	         <div id="user-btn" class="fas fa-user"></div>
	        </div>
	        <div class="profile">
	         <p class="name"><?= $_SESSION["username"]; ?></p>
	         <a href="logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
	      </div>
		</section>
	</header>
	
	<article>
		<?php
			if(@$_GET["page"] == "barang"){
				include "page/barang.php";
			}
			else if(@$_GET["page"] == "aset"){
				include "page/aset.php";
			}
			else if(@$_GET["page"] == "penjualan"){
				include "page/penjualan.php";
			}
			else if(@$_GET["page"] == "perumahan"){
				include "page/perumahan.php";
			}
			else if(@$_GET["page"] == "driver"){
				include "page/driver.php";
			}
			else if(@$_GET["page"] == "user"){
				include "page/user.php";
			}
			else{
				echo "<p class=about>Welcome , ".$_SESSION["username"]."</p>";
			}
		?>
	</article>
	<footer>
		<small>&copy; 2013 Fajar Muhammad F</small>
	</footer>
	<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

	<!-- custom js file link  -->
	<script src="../js/script.js"></script>

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
