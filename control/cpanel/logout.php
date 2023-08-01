<?php
	session_start();
	include "../include/koneksi.php";
	$Koneksi = new Hubungi();

	$Koneksi->Konek("fandystore");

	$username = $_SESSION["username"];
	$password = $_SESSION["password"];
	
	unset($_COOKIE['token']);

    setcookie('token', '', time() - 3600);
    setcookie('token', '', time() - 3600,"/");									

	$query="UPDATE `user-manager` SET token = '',token_key='',token_value='' WHERE username = ? AND password = ? ";
	$exquery=$Koneksi->getKonek()->prepare($query);
	$exquery->bind_param("ss",$username,$password);
	$exquery->execute();
	
	session_destroy();

	header("location:../index.php");
?>
