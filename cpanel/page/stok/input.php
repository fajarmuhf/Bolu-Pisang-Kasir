		<form action="?page=stok&i=input&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Input</td>
			</tr>
			<tr>
				<td>Id User : </td><td>
					<?php
						include "include/koneksi.php";
						include "include/stok.php";
						
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
						
						$query = "SELECT * FROM User WHERE 1";
						$exquery = mysqli_query($Koneksi->getKonek(),$query);
						if($exquery){
							echo "<select name=id_user >";
							while($hasil = mysqli_fetch_array($exquery)){
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
				<td>Id Barang : </td><td>
					<?php
						$query = "SELECT * FROM Barang WHERE 1";
						$exquery = mysqli_query($Koneksi->getKonek(),$query);
						if($exquery){
							echo "<select name=id_barang >";
							while($hasil = mysqli_fetch_array($exquery)){
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
				<td>Jumlah : </td><td><input type="text" name="jumlah" id="jumlah"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				if(@$_GET["kirim"] == 1){
					if(@$_POST["id_user"] != "" && @$_POST["id_barang"] != "" && @$_POST["jumlah"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$id_user = $_POST["id_user"];
						$id_barang = $_POST["id_barang"];
						$jumlah = $_POST["jumlah"];
								
						$ob1 = new Stok();
						$ob1->setIduser($id_user);
						$ob1->setIdbarang($id_barang);
						$ob1->setJumlah($jumlah);
								
						$query2 = "SELECT COUNT(*) From Stok WHERE UPPER(Id_User) = UPPER('".$ob1->getIduser()."') AND UPPER(Id_Barang) = UPPER('".$ob1->getIdbarang()."')";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil = mysqli_fetch_array($exquery2);
							if($hasil[0] == 0){							
								$query = "INSERT INTO `Stok` SELECT (COUNT(*)+1),'".$ob1->getIduser()."','".$ob1->getIdbarang()."','".$ob1->getJumlah()."' FROM `Stok` WHERE (SELECT COUNT(*) From Stok WHERE UPPER(Id_Barang) = UPPER('".$ob1->getIdbarang()."') AND UPPER(Id_User) = UPPER('".$ob1->getIduser()."')) = 0";
								$exquery = mysqli_query($Koneksi->getKonek(),$query);
								if($exquery){
									echo "Anda telah berhasil menginput data<br>";
								}
								else{
									echo "Anda tidak berhasil menginput data<br>";
								}
							}
							else{
								echo "Anda tidak berhasil menginput data<br>";
							}
						}
						mysqli_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
