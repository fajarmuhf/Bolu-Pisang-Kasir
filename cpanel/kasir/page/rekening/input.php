		<form action="?page=rekening&i=input&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Input</td>
			</tr>
			<tr>
				<td>Id User : </td><td>
					<?php
						include "include/koneksi.php";
						
						$Koneksi = new Hubungi();
						$Koneksi->Konek("penjualan_mobil");
						
						$query = "SELECT * FROM User WHERE 1";
						$exquery = mysql_query($query);
						if($exquery){
							echo "<select name=id_user >";
							while($hasil = mysql_fetch_array($exquery)){
								echo "<option value=".$hasil['Id'].">".$hasil['Id']." - ".$hasil['Username']."</option>";
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
				<td>Saldo : </td><td><input type="text" name="saldo" id="saldo"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/rekening.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["id_user"] != "" && @$_POST["saldo"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("penjualan_mobil");
								
						$id_user = $_POST["id_user"];
						$saldo = $_POST["saldo"];
								
						$ob1 = new Rekening();
						$ob1->setIduser($id_user);
						$ob1->setSaldo($saldo);
								
						$query = "INSERT INTO `Rekening` SELECT (COUNT(*)+1),'".$ob1->getIduser()."','".$ob1->getSaldo()."' FROM `Rekening` WHERE 1 ";
						$exquery = mysql_query($query);
						if($exquery){
							echo "Anda telah berhasil menginput data<br>";
						}
						else{
							echo "Anda tidak berhasil menginput data<br>";
						}
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
