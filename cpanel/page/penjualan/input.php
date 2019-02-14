		<script>
		  $(function() {
			$( "#tanggal" ).datetimepicker();
		  });
		</script>
		<form action="?page=penjualan&i=input&kirim=1" method="post">
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
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/penjualan.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["tanggal"] != "" && @$_POST["id_user"] != "" && @$_POST["id_barang"] != "" && @$_POST["jumlah"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$tanggal = $_POST["tanggal"];
						$id_user = $_POST["id_user"];
						$id_barang = $_POST["id_barang"];
						$jumlah = $_POST["jumlah"];
								
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
							$query = "INSERT INTO `Penjualan` SELECT (COUNT(*)+1),'".$ob1->getTanggal()."','".$ob1->getIduser()."','".$ob1->getIdbarang()."','".$ob1->getJumlah()."','".$total."','".($total*2.5/100)."' FROM `Penjualan` WHERE 1 ";
							$exquery = mysql_query($query);
							if($exquery){
								echo "Anda telah berhasil menginput data<br>";
							}
							else{
								echo "Anda tidak berhasil menginput data<br>";
							}
						}
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
