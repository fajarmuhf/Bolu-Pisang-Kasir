<?php
	session_start();
?>
<!DOCTYPE HTML>
<head>
	<title>Perusahaan Jual Beli</title>
	<link rel="stylesheet" href="../style.css" >
	<script src="../js/jquery-1.9.1.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<script src="../js/jquery-ui-timepicker-addon.js"></script>
	<link rel="stylesheet" href="../css/jquery-ui.css" >
	<link rel="stylesheet" href="../js/jquery-ui-timepicker-addon.js">
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
			top:200px;
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
			top:200px;
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
				hideOnMouseOut: false
			}
		});
	</script>
</head>
<body>
	<header>
		<h2>Perusahaan Jual Beli</h2>
	</header>
	<nav>
		<ul>
			<li class="puter"><a href="logout.php" >Logout</a></li>
			<li class="puter"><a href="?page=barang">Barang Produksi</a></li>
			<li class="puter"><a href="?page=mentah">Barang Mentah</a></li>
			<li class="puter"><a href="?page=stok" >Stok</a></li>
			<li class="puter"><a href="?page=penjualan">Penjualan</a></li>
			<li class="puter"><a href="?page=pengiriman">Pengiriman</a></li>
			<li class="puter"><a href="?page=pengeluaran">Pengeluaran</a></li>
			<li class="puter"><a href="?page=keuntungan">Keuntungan</a></li>
			<li class="puter"><a href="?page=user">User</a></li>
		</ul>
	</nav>
	<article>
		<?php
			if(@$_GET["page"] == "barang"){
				include "page/barang.php";
			}
			else if(@$_GET["page"] == "penjualan"){
				include "page/penjualan.php";
			}
			else if(@$_GET["page"] == "stok"){
				include "page/stok.php";
			}
			else if(@$_GET["page"] == "pengiriman"){
				include "page/pengiriman.php";
			}
			else if(@$_GET["page"] == "pengeluaran"){
				include "page/pengeluaran.php";
			}
			else if(@$_GET["page"] == "keuntungan"){
				include "page/keuntungan.php";
			}
			else if(@$_GET["page"] == "mentah"){
				include "page/mentah.php";
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
</body>
</html>
