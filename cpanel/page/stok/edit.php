		<form action="?page=stok&i=edit&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Edit</td>
			</tr>
			<tr>
				<td>Atribut : </td>
				<td>
					<select name="atribut" id="atribut">
						<option value="Id">Id</option>
						<option value="Id_User">Id User</option>
						<option value="Id_Barang">Id Barang</option>
						<option value="Jumlah">Jumlah</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Nilai : </td><td><input type="text" name="nilai" id="nilai"></td>
			</tr>
			<tr>
				<td>Id User : </td><td>
					<?php
						include "include/koneksi.php";
						include "include/stok.php";
						
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
						
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
				<td>Id Barang : </td><td>
					<?php
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
						
						$query = "SELECT * FROM Barang WHERE 1";
						$exquery = mysql_query($query);
						if($exquery){
							echo "<select name=id_barang >";
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
				<td>Jumlah : </td><td><input type="text" name="jumlah" id="jumlah"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Edit </button></td>
			</tr>
			</table>
			<?php
			
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
			
			
				if(@$_GET["kirim"] == 1){
					if(@$_POST["id_user"] != "" && @$_POST["id_barang"] != "" && @$_POST["jumlah"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$id_user = $_POST["id_user"];
						$id_barang = $_POST["id_barang"];
						$jumlah = $_POST["jumlah"];
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
								
						$ob1 = new Stok();
						$ob1->setIduser($id_user);
						$ob1->setIdbarang($id_barang);
						$ob1->setJumlah($jumlah);
						
						$query = "SELECT COUNT(*) From Stok WHERE UPPER(Id_User) = UPPER('".$ob1->getIduser()."') AND UPPER(Id_Barang) = UPPER('".$ob1->getIdbarang()."')";
						$exquery = mysql_query($query);
						if($exquery){		
							$hasil = mysql_fetch_array($exquery);
							if($hasil[0] > 0){
								$query2 = "UPDATE `Stok` SET Id_User = ".$ob1->getIduser().",Id_Barang = ".$ob1->getIdbarang().",Jumlah = '".$ob1->getJumlah()."' WHERE $atribut = '$nilai' ";
								$exquery2 = mysql_query($query2);
								if($exquery2){
									echo "Anda telah berhasil mengedit data<br>";
								}
								else{
									echo "Anda tidak berhasil mengedit data<br>";
								}
							}
							else{
								echo "Anda tidak berhasil mengedit data<br>";
							}
						}
						else{
							echo "Anda tidak berhasil mengedit data<br>";
						}
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
