		<script>
		  $(function() {
			$( "#tanggal" ).datetimepicker();
		  });
		</script>
		<form action="?page=pengeluaran&i=input&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Input</td>
			</tr>
			<tr>
				<td>Tanggal : </td><td><input type="text" name="tanggal" id="tanggal"></td>
			</tr>
			<tr>
				<td>Id Barang : </td><td>
					<?php
						include "include/koneksi.php";
						
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
						
						$query = "SELECT * FROM Barang_Mentah WHERE 1";
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
					if(@$_POST["tanggal"] != "" && @$_POST["id_barang"] != "" && @$_POST["jumlah"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$tanggal = $_POST["tanggal"];
						$id_barang = $_POST["id_barang"];
						$jumlah = $_POST["jumlah"];
								
						$tanggal = date("Y-m-d H:m", strtotime($tanggal));
						$tanggal = $tanggal.":00";
						
						$ob1 = new Penjualan();
						$ob1->setTanggal($tanggal);
						$ob1->setIdbarang($id_barang);
						$ob1->setJumlah($jumlah);
						$query2 = "SELECT Harga FROM Barang_Mentah WHERE Id = '".$ob1->getIdbarang()."'";
						$exquery2 = mysql_query($query2);
						if($exquery2){
							$hasil = mysql_fetch_array($exquery2);
							$total = ($ob1->getJumlah()*$hasil[0]);
							$query = "INSERT INTO `Pengeluaran` SELECT (COUNT(*)+1),'".$ob1->getTanggal()."','".$ob1->getIdbarang()."','".$ob1->getJumlah()."','".$total."' FROM `Pengeluaran` WHERE 1 ";
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
