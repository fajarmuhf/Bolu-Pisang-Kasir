<?php
	if(!(isset($_SESSION['username']) && isset($_SESSION['password']))){
		if(@$_SESSION['status']!="admin"){
			header('location:../index.php');
		}
	}
?>