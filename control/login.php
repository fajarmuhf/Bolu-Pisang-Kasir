<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "include/koneksi.php";
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

	if(isset($_SESSION["username"]) && isset($_SESSION['password']) && isset($_SESSION['status'])){
		if($_SESSION['status'] == 'admin'){
			echo "<script>window.location='cpanel/admin.php'</script>";
		}
		else if($_SESSION['status'] == 'kasir'){
			echo "<script>window.location='cpanel/kasir.php'</script>";
		}
	}
?>
<!DOCTYPE HTML>
<head>
	<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0,  minimum-scale=1"/> 
	<title><?php 
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
				<a href="login.php">Login</a>
				<a href="about.php">About</a>
			</nav>
		</section>
	</header>
	<article>
		<div style="flex: 1 1 100rem;">
			<div style="width:100%;margin: auto;">
				<form action="?Login=1" method="post">
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

										$username = $_SESSION["username"];
										$password = $_SESSION['password'];

										$expires = time() + ((60*60*24) * 7);
										
										$salt = "*&salt#@";
										
										$token_key = hash('sha256', (time() . $salt));
										$token_value = hash('sha256', ('Logged_in' . $_SESSION["username"] . $_SESSION["password"]));
										unset($_COOKIE['token']);
    									setcookie('token', '', time() - 3600);
										setcookie("token",$token_key.':'.$token_value,$expires,"/");

										$query2 = "UPDATE `user-manager` SET token_key = ?, token_value = ? WHERE Username = ? AND Password = ?";
										$exquery2=$Koneksi->getKonek()->prepare($query2);
										$exquery2->bind_param("ssss",$token_key,$token_value,$username,$password);
										$exquery2->execute();

										if($tampil[0]['Status'] == 'admin'){
											echo '
											<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"></script>
										    <script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"></script>
										    <script>
										        const firebaseConfig = {
												  apiKey: "AIzaSyDs6a-6Wp8G-a5mJEvYThT1v7qHF0IcKx0",
												  authDomain: "push-notification-51431.firebaseapp.com",
												  projectId: "push-notification-51431",
												  storageBucket: "push-notification-51431.appspot.com",
												  messagingSenderId: "569866202554",
												  appId: "1:569866202554:web:f53cb40ccc18d9b3f88183"
												};
										        const app = firebase.initializeApp(firebaseConfig)
										        const messaging = firebase.messaging();

										        messaging.getToken({ vapidKey: "BO5Aq7APdNKSDE2zUR4rduUCIVJciPmfMs6MttYlBQhUeNb0RQPPF35tmqQ8FhNsbTfWGCNzlV9nbYQDmYr_aoQ" }).then((currentToken) => {
										            // app token used for sending notifications
										            if (currentToken) {
										                console.log(currentToken);
										                jQuery.ajax({
															url:"pushToken.php",
															data:"user='.$_SESSION["username"].'&pass='.$_SESSION["password"].'&token="+currentToken,
															type:"post",
															success:function(result){
																window.location="cpanel/admin.php";
															}
														});
										                sendTokenToServer(currentToken)
										            }else{
										                setTokenSentToServer(false);
										            }
										        }).catch((err) => {
										            // notifications are manually blocked, you can ask for unblock here
										            console.log("An error occurred while retrieving token. ", err);
										            setTokenSentToServer(false);
										        });

										        messaging.onMessage((payload) => {
										            // notification data receive here, use it however you want
										            // keep in mind if message receive here, it will not notify in background
										            console.log("Message received. ", payload);
										            const messagesElement = document.querySelector(".message");
										            const dataHeaderElement = document.createElement("h5");
										            const dataElement = document.createElement("pre");
										            dataElement.style = "overflow-x:hidden;";
										            dataHeaderElement.textContent = "Message Received:";
										            dataElement.textContent = JSON.stringify(payload, null, 2);
										            messagesElement.appendChild(dataHeaderElement);
										            messagesElement.appendChild(dataElement);
										        });

										        function sendTokenToServer(currentToken) {
										            if (!isTokenSentToServer()) {
										                console.log("Sending token to server...");
										                // TODO(developer): Send the current token to your server.
										                setTokenSentToServer(true);
										            } else {
										                console.log("Token already available in the server");
										            }
										        }

										        function isTokenSentToServer() {
										            return window.localStorage.getItem("sentToServer") === "1";
										        }

										        function setTokenSentToServer(sent) {
										            window.localStorage.setItem("sentToServer", sent ? "1" : "0");
										        }
											</script>';
										}
										else if($tampil[0]['Status'] == 'kasir'){
											echo '<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"></script>
										    <script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"></script>
										    <script>
										        const firebaseConfig = {
												  apiKey: "AIzaSyDs6a-6Wp8G-a5mJEvYThT1v7qHF0IcKx0",
												  authDomain: "push-notification-51431.firebaseapp.com",
												  projectId: "push-notification-51431",
												  storageBucket: "push-notification-51431.appspot.com",
												  messagingSenderId: "569866202554",
												  appId: "1:569866202554:web:f53cb40ccc18d9b3f88183"
												};
										        const app = firebase.initializeApp(firebaseConfig)
										        const messaging = firebase.messaging();

										        messaging.getToken({ vapidKey: "BO5Aq7APdNKSDE2zUR4rduUCIVJciPmfMs6MttYlBQhUeNb0RQPPF35tmqQ8FhNsbTfWGCNzlV9nbYQDmYr_aoQ" }).then((currentToken) => {
										            // app token used for sending notifications
										            if (currentToken) {
										                console.log(currentToken);
										                jQuery.ajax({
															url:"pushToken.php",
															data:"user='.$_SESSION["username"].'&pass='.$_SESSION["password"].'&token="+currentToken,
															type:"post",
															success:function(result){
																window.location="cpanel/kasir.php";
															}
														});
										                sendTokenToServer(currentToken)
										            }else{
										                setTokenSentToServer(false);
										            }
										        }).catch((err) => {
										            // notifications are manually blocked, you can ask for unblock here
										            console.log("An error occurred while retrieving token. ", err);
										            setTokenSentToServer(false);
										        });

										        messaging.onMessage((payload) => {
										            // notification data receive here, use it however you want
										            // keep in mind if message receive here, it will not notify in background
										            console.log("Message received. ", payload);
										            const messagesElement = document.querySelector(".message");
										            const dataHeaderElement = document.createElement("h5");
										            const dataElement = document.createElement("pre");
										            dataElement.style = "overflow-x:hidden;";
										            dataHeaderElement.textContent = "Message Received:";
										            dataElement.textContent = JSON.stringify(payload, null, 2);
										            messagesElement.appendChild(dataHeaderElement);
										            messagesElement.appendChild(dataElement);
										        });

										        function sendTokenToServer(currentToken) {
										            if (!isTokenSentToServer()) {
										                console.log("Sending token to server...");
										                // TODO(developer): Send the current token to your server.
										                setTokenSentToServer(true);
										            } else {
										                console.log("Token already available in the server");
										            }
										        }

										        function isTokenSentToServer() {
										            return window.localStorage.getItem("sentToServer") === "1";
										        }

										        function setTokenSentToServer(sent) {
										            window.localStorage.setItem("sentToServer", sent ? "1" : "0");
										        }</script>';
										}
									}
									else{
										echo "<div style='margin-top:10px'>Maaf Username atau Password salah</div>";
									}
								}
								else{
									echo "<div style='margin-top:10px'>Maaf Username atau Password salah</div>";
								}
								$exquery->close();
							}
							else{
								echo "<div style='margin-top:10px'>Data disi terlebih dahulu</div>";
							}
						}
					?>
				</form>
			</div>
		</div>
	</article>
	<footer>
		<small>&copy; 2013 Fajar Muhammad F</small>
	</footer>
</body>
</html>
