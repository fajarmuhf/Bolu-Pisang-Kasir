<?php
	include "include/koneksi.php";
	include "include/stok.php";
						
	if(@$_GET["id"] != "" && @$_GET["status"] != ""){
		$Koneksi = new Hubungi();
		$Koneksi->Konek("bolu_pisang");
						
		$query = "UPDATE Pengiriman SET Status = '".$_GET['status']."' WHERE Id = '".$_GET['id']."'";
		$exquery = mysql_query($query);
		if($exquery){
			$query2 = "SELECT * FROM Pengiriman WHERE Id = '".$_GET['id']."'";
			$exquery2 = mysql_query($query2);
			if($exquery2){
				$hasil = mysql_fetch_array($exquery2);
				$jumlah=$hasil['Jumlah'];
				$id_barang=$hasil['Id_Barang'];
				$id_user=$hasil['Id_Target'];
				
				$query3 = "UPDATE Stok SET Jumlah = (Jumlah+".$jumlah.") WHERE Id_Barang = '".$id_barang."' AND Id_User = '".$id_user."'";
				$exquery3 = mysql_query($query3);
				if($exquery3){
					echo "<script>window.location='?page=stok&i=cek'</script>";
				}
				else{
					echo "Anda tidak berhasil mengedit data<br>";
				}
			}
		}
		else{
			echo "Anda tidak berhasil mengedit data<br>";
		}
	}
?>
