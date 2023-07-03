<?php
	session_start();
	if(isset($_SESSION["name"]) && isset($_SESSION['email']) && isset($_SESSION['id'])){
		echo "<script>window.location='cpanel/admin.php'</script>";
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
				<?php
					require_once 'vendor/autoload.php';
					
					$Koneksi->Konek("fandystore");
						
					// init configuration
					$nama = "google";
					$query="SELECT * FROM `auth-secret` WHERE name = ?";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("s",$nama);
					$exquery->execute();
					if($exquery){
						$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
						$clientID = $tampil[0]["client_id"];
						$clientSecret = $tampil[0]["client_secret"];
						$redirectUri = $tampil[0]["redirect_uri"];
					}
					   
					// create Client Request to access Google API
					$client = new Google_Client();
					$client->setClientId($clientID);
					$client->setClientSecret($clientSecret);
					$client->setRedirectUri($redirectUri);
					$client->addScope("email");
					$client->addScope("profile");
					  
					// authenticate code from Google OAuth Flow
					if (isset($_GET['code'])) {
					  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
					  $client->setAccessToken($token['access_token']);
					   
					  // get profile info
					  $google_oauth = new Google_Service_Oauth2($client);
					  $google_account_info = $google_oauth->userinfo->get();
					  $_SESSION['email'] =  $google_account_info->email;
					  $_SESSION['name'] =  $google_account_info->name;
					  $_SESSION['id'] =  $google_account_info->id;

					  echo "<script>window.location='cpanel/admin.php'</script>";
					  
					  // now you can use this profile info to create account in your website and make user logged in.
					} else {
					  echo "<a class=\"btn btn-outline-dark\" href='".$client->createAuthUrl()."' role=\"button\" style=\"text-transform:none\">
					      <img width=\"20px\" style=\"margin-bottom:3px; margin-right:5px\" alt=\"Google sign-in\" src='https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_\"G\"_Logo.svg/512px-Google_\"G\"_Logo.svg.png' />
					      Login with Google
					    </a>";
					}
				?>
			</div>
		</div>
	</article>
	<!-- custom js file link  -->
	<script src="js/script.js"></script>

	<footer>
		<small>&copy; 2013 Fajar Muhammad F</small>
	</footer>
</body>
</html>
