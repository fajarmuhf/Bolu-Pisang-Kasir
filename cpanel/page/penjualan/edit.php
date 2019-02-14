		<script>
		  $(function() {
			$( "#tanggal" ).datetimepicker();
		  });
		</script>
		<form action="?page=penjualan&i=edit&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Edit</td>
			</tr>
			<tr>
				<td>Atribut : </td>
				<td>
					<select name="atribut" id="atribut">
						<option value="Id">Id</option>
						<option value="Tanggal">Tanggal</option>
						<option value="Id_Barang">Id Barang</option>
						<option value="Id_Mobil">Id Mobil</option>
						<option value="Jumlah">Jumlah</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Nilai : </td><td><input type="text" name="nilai" id="nilai"></td>
			</tr>
			<tr>
				<td>Tanggal : </td><td><input type="text" name="tanggal" id="tanggal"></td>
			</tr>
			<tr>
				<td>Id User : </td><td>
					<?php
						include "include/koneksi.php";
						
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
				include "include/penjualan.php";
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["tanggal"] != "" && @$_POST["id_user"] != "" && @$_POST["id_barang"] != "" && @$_POST["jumlah"] != "" &&
					@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$tanggal = $_POST["tanggal"];
						$id_user = $_POST["id_user"];
						$id_barang = $_POST["id_barang"];
						$jumlah = $_POST["jumlah"];
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
						
						$tanggal = date("Y-m-d H:m", strtotime($tanggal));
						$tanggal = $tanggal.":00";
						
						$ob1 = new Penjualan();
						$ob1->setTanggal($tanggal);
						$ob1->setIduser($id_user);
						$ob1->setIdbarang($id_barang);
						$ob1->setJumlah($jumlah);
						$query2 = "SELECT Harga FROM Barang WHERE Id = '".$ob1->getIdbarang()."'";
						$exquery2 = mysql_query($query2);
						if($exquery2){
							$hasil = mysql_fetch_array($exquery2);
							$total = ($ob1->getJumlah()*$hasil[0]);						
							$query = "UPDATE `Penjualan` SET Tanggal = '".$ob1->getTanggal()."',Id_User = '".$ob1->getIduser()."',Id_Barang = ".$ob1->getIdbarang().",Jumlah = ".$ob1->getJumlah().",Total = ".$total.",Zakat = ".($total*2.5/100)." WHERE $atribut = '$nilai' ";
							$exquery = mysql_query($query);
							if($exquery){
								echo "Anda telah berhasil mengedit data<br>";
							}
							else{
								echo "Anda tidak berhasil mengedit data<br>";
							}
						}
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
