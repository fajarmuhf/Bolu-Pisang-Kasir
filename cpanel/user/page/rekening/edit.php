		<form action="?page=rekening&i=edit&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Edit</td>
			</tr>
			<tr>
				<td>Atribut : </td>
				<td>
					<select name="atribut" id="atribut">
						<option value="Id">Id</option>
						<option value="Nama">Nama</option>
						<option value="Harga">Harga</option>
						<option value="Tahun">Tahun</option>
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
				<td colspan=2><button class="button"> Edit </button></td>
			</tr>
			</table>
			<?php
				include "include/rekening.php";
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["id_user"] != "" && @$_POST["saldo"] != "" &&
					@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("penjualan_mobil");
								
						$id_user = $_POST["id_user"];
						$saldo = $_POST["saldo"];
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
						
						$ob1 = new Rekening();
						$ob1->setIduser($id_user);
						$ob1->setSaldo($saldo);
								
						$query = "UPDATE `Rekening` SET Id_User = '".$ob1->getIduser()."',Saldo = '".$ob1->getSaldo()."' WHERE $atribut = $nilai ";
						$exquery = mysql_query($query);
						if($exquery){
							echo "Anda telah berhasil mengedit data<br>";
						}
						else{
							echo "Anda tidak berhasil mengedit data<br>";
						}
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
