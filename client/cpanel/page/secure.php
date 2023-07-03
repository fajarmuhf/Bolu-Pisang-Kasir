<?php
	if(!(isset($_SESSION['id']) &&isset($_SESSION['email']) && isset($_SESSION['name']))){
		header('location:../index.php');
	}
?>