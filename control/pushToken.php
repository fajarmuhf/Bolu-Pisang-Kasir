<?php
	date_default_timezone_set('Asia/Jakarta');
	include "include/koneksi.php";
	$Koneksi = new Hubungi();

	$Koneksi->Konek("fandystore");
	
	if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['token'])){
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$token = $_POST['token'];

		$query="SELECT COUNT(*),Status FROM `user-manager` WHERE Username = ? AND Password = ?";
		$exquery=$Koneksi->getKonek()->prepare($query);
		$exquery->bind_param("ss",$user,$pass);
		$exquery->execute();
		if($exquery){
			$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
			if($tampil[0]['COUNT(*)'] > 0){
				$query2="UPDATE `user-manager` SET token = ? WHERE Username = ? AND Password = ?";
				$exquery2=$Koneksi->getKonek()->prepare($query2);
				$exquery2->bind_param("sss",$token,$user,$pass);
				$exquery2->execute();
			}
		}
	}
?>