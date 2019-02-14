<!DOCTYPE HTML>
<head>
	<title>Perusahaan Bolu Pisang</title>
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui.js"></script>
	<link rel="stylesheet" href="style.css" >
	<link rel="stylesheet" href="css/jquery-ui.css" >
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
		<form action="login.php?Login=1" method="post">
			<table class=Login>
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
	</article>
	<footer>
		<small>&copy; 2013 Fajar Muhammad F</small>
	</footer>
</body>
</html>
