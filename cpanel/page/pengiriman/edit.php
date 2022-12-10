		<script>
		  $(function() {
			$( "#tanggal" ).datetimepicker();
		  });
		</script>
		<form action="?page=pengiriman&i=edit&kirim=1" method="post">
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
						<option value="Id_User">Id User</option>
						<option value="Id_Target">Id Target</option>
						<option value="Id_Barang">Id Barang</option>
						<option value="Jumlah">Jumlah</option>
						<option value="Status">Status</option>
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
				<td>Id Target : </td><td>
					<?php
						
						$query = "SELECT * FROM User WHERE 1";
						$exquery = mysql_query($query);
						if($exquery){
							echo "<select name=id_target >";
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
				<td>Status : </td>
				<td>
					<select name=status>
						<option value="tertunda">tertunda</option>
						<option value="diterima">diterima</option>
						<option value="dibatalkan">dibatalkan</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Edit </button></td>
			</tr>
			</table>
			<?php
				include "include/pengiriman.php";
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["tanggal"] != "" && @$_POST["id_user"] != "" && @$_POST["id_target"] && @$_POST["id_barang"] != "" && @$_POST["jumlah"] != "" && @$_POST["status"] &&
					@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
						
						$tanggal = $_POST["tanggal"];
						$id_user = $_POST["id_user"];
						$id_target = $_POST["id_target"];
						$id_barang = $_POST["id_barang"];
						$jumlah = $_POST["jumlah"];
						$status = $_POST["status"];
								
						$tanggal = date("Y-m-d H:m", strtotime($tanggal));
						$tanggal = $tanggal.":00";
						
						$ob1 = new Pengiriman();
						$ob1->setTanggal($tanggal);
						$ob1->setIduser($id_user);
						$ob1->setIdtarget($id_target);
						$ob1->setIdbarang($id_barang);
						$ob1->setJumlah($jumlah);
						$ob1->setStatus($status);
						$query = "UPDATE `Pengiriman` SET Tanggal = '".$ob1->getTanggal()."',Id_User = '".$ob1->getIduser()."',Id_Target = '".$ob1->getIdtarget()."',Id_Barang = ".$ob1->getIdbarang().",Jumlah = ".$ob1->getJumlah().",Status = '".$ob1->getStatus()."' WHERE $atribut = '$nilai' ";
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
