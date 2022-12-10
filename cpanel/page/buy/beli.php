<form action="?page=buy&kirim=1" method="post">
	<table align=center class=Login>
			<tr>
				<td colspan=2>Beli Mobil</td>
			</tr>
			<tr>
				<td colspan=2 ><p id=Tampil></p></td>
			</tr>
			<tr>
			<td>Mobil : </td><td>
					<?php
						include "../include/koneksi.php";
						
						$Koneksi = new Hubungi();
						$Koneksi->Konek("penjualan_mobil");
						
						$query = "SELECT * FROM Mobil WHERE 1";
						$exquery = mysql_query($query);
						if($exquery){
							echo "<select name=id_mobil id=id_mobil onchange='upDateGambar()' >";
							while($hasil = mysql_fetch_array($exquery)){
								echo "<option value=".$hasil['Id'].">".$hasil['Id']." - ".$hasil['Nama']."</option>";
							}
							echo "</select>";
						}
						else{
							echo "koneksi gagal";
						}
					?>
				</td>
			</tr>
			<tr>
				<td>Quantity : </td><td><input type="text" name="quantity" id="quantity" onInput="upDateHarga()" ></td>
			</tr>
			<tr>
				<td>Total : </td><td><o id=Total></o></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Beli </button></td>
			</tr>
		</table>
		</form>
		<?php
				include "page/penjualan/include/penjualan.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["id_mobil"] != "" && @$_POST["quantity"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("penjualan_mobil");
						
						$username = $_SESSION["username"];
						
						$query = "SELECT * FROM `User` WHERE Username = '$username' ";
						$exquery = mysql_query($query);
						if($exquery){
							if($hasil = mysql_fetch_array($exquery)){
								$id_user = $hasil['Id'];
								$id_mobil = $_POST["id_mobil"];
								$quantity = $_POST["quantity"];
										
								$tanggal = date("Y-m-d H:m:s");
								
								$ob1 = new Penjualan();
								$ob1->setTanggal($tanggal);
								$ob1->setIduser($id_user);
								$ob1->setIdmobil($id_mobil);
								$ob1->setQuantity($quantity);
								
								$query2 = "SELECT Saldo FROM Rekening WHERE Id_User = '".$ob1->getIduser()."'";
								$exquery2 = mysql_query($query2);
								if($exquery2){		
									$saldo = mysql_fetch_array($exquery2);
									$query3 = "SELECT Harga FROM Mobil WHERE Id = '".$ob1->getIdmobil()."'";
									$exquery3 = mysql_query($query3);
									if($exquery3){
										$harga = mysql_fetch_array($exquery3);
										$query4 = "UPDATE Stok SET Jumlah = (Jumlah-".$ob1->getQuantity().") WHERE Id_Mobil = '".$ob1->getIdmobil()."' AND Jumlah >= ".$ob1->getQuantity()." AND ".$saldo[0]." >= (".$ob1->getQuantity()."*".$harga[0].") ";
										$exquery4 = mysql_query($query4);
										if($exquery4){
											$query5 = "INSERT INTO `Penjualan` SELECT (COUNT(*)+1),'".$ob1->getTanggal()."','".$ob1->getIduser()."','".$ob1->getIdmobil()."','".$ob1->getQuantity()."' FROM `Penjualan` WHERE ".$ob1->getQuantity()."*(SELECT Harga FROM Mobil WHERE Id = '".$ob1->getIdmobil()."') <= ".$saldo['Saldo'];
											$exquery5 = mysql_query($query5);
											if($exquery5){
												$query6 = "UPDATE Rekening SET Saldo = (Saldo-(".$ob1->getQuantity()."*".$harga[0].")) WHERE Id_User = '".$ob1->getIduser()."'";
												$exquery6 = mysql_query($query6);
												if($exquery6){
													echo "Selamat Anda telah berhasil membeli mobil<br>";
												}
												else{
													echo "Maaf Anda tidak berhasil membeli mobil<br>";
												}
											}
											else{
												echo "Maaf Saldo Anda tidak cukup untuk membeli mobil<br>";
											}
										}
										else{
											echo "Maaf Stok sudah habis atau Saldo anda tidak cukup <br>";
										}
									}
									else{
										echo "Maaf Anda tidak berhasil membeli mobil<br>";
									}
								}
								else{
									echo "Maaf Anda tidak berhasil membeli mobil<br>";
								}
							}
						}
						else{
							echo "Anda tidak berhasil membeli<br>";
						}
								
						
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
<script>
function upDateHarga(){
	var Harga=new Array();
	
	<?php
						
		$Koneksi = new Hubungi();
		$Koneksi->Konek("penjualan_mobil");
						
		$query = "SELECT * FROM Mobil WHERE 1 ";
		$exquery = mysql_query($query);
		if($exquery){
			$i=1;
			while($hasil = mysql_fetch_array($exquery)){
				echo "Harga[$i] = ".$hasil['Harga'].";\n";
				$i++;
			}
		}
		else{
			echo "koneksi gagal";
		}
	?>
	if(document.getElementById('quantity').value == ""){
		document.getElementById('Total').innerHTML = "";
	}
	else{
		document.getElementById('Total').innerHTML = parseInt(document.getElementById('quantity').value)*Harga[document.getElementById('id_mobil').value];
	}
}
function upDateGambar(){
	var Gambar=new Array();
	<?php
						
		$Koneksi = new Hubungi();
		$Koneksi->Konek("penjualan_mobil");
						
		$query = "SELECT * FROM Mobil WHERE 1 ";
		$exquery = mysql_query($query);
		if($exquery){
			$i=1;
			while($hasil = mysql_fetch_array($exquery)){
				echo "Gambar[$i] = '".$hasil['Gambar']."';\n";
				$i++;
			}
		}
		else{
			echo "koneksi gagal";
		}
	?>
	
	if(document.getElementById('id_mobil').value == ""){
		document.getElementById('Tampil').innerHTML = "";
	}
	else{
		document.getElementById('Tampil').innerHTML = "<a href='upload/"+Gambar[document.getElementById('id_mobil').value]+"'  onclick='return hs.expand(this)' class='highslide'><img src='upload/"+Gambar[document.getElementById('id_mobil').value]+"' width=130px height=130px ></a>";
	}
}	
upDateGambar();
</script>
