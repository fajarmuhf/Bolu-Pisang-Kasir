		<script>
		  $(function() {
			$( "#tanggal" ).datetimepicker();
		  });
		</script>
		<form action="?page=pengiriman&i=input&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Input</td>
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
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/pengiriman.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["tanggal"] != "" && @$_POST["id_user"] != "" && @$_POST["id_target"] != "" && @$_POST["id_barang"] != "" && @$_POST["jumlah"] != "" && @$_POST["status"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
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
						$query = "INSERT INTO `Pengiriman` SELECT (COUNT(*)+1),'".$ob1->getTanggal()."','".$ob1->getIduser()."','".$ob1->getIdtarget()."','".$ob1->getIdbarang()."','".$ob1->getJumlah()."','".$ob1->getStatus()."' FROM `Pengiriman` WHERE 1 ";
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
