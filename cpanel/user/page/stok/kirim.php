		<script>
		  $(function() {
			$( "#tanggal" ).datetimepicker();
		  });
		</script>
		<?php
			echo "<form action='?page=stok&i=kirim&id=".$_GET["id"]."&kirim=1' method='post'>"
		?>
			<table align=center class=Login>
			<tr>
				<td colspan=2>Edit</td>
			</tr>
			<tr>
				<td>Id Target : </td><td>
					<?php
						include "include/koneksi.php";
						
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
						
						$query = "SELECT * FROM User WHERE Username != '".$_SESSION['username']."'";
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
				<td colspan=2><button class="button"> Kirim </button></td>
			</tr>
			</table>
			<?php
				include "include/pengiriman.php";
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["id_target"] != "" && @$_POST["id_barang"] != "" && @$_POST["jumlah"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$atribut = 'Id';
						$nilai = $_GET['id'];
						
						$tanggal = date("Y-m-d H:m:s");
						
						$kueh = "SELECT Id FROM User WHERE Username = '".$_SESSION['username']."'";
						$exkueh = mysql_query($kueh);
						if($exkueh){
							$hasil = mysql_fetch_array($exkueh);
							$id_user = $hasil[0];
							$id_target = $_POST["id_target"];
							$id_barang = $_POST["id_barang"];
							$jumlah = $_POST["jumlah"];
							$status = 'tertunda';
									
							$ob1 = new Pengiriman();
							$ob1->setTanggal($tanggal);
							$ob1->setIduser($id_user);
							$ob1->setIdtarget($id_target);
							$ob1->setIdbarang($id_barang);
							$ob1->setJumlah($jumlah);
							$ob1->setStatus($status);
							$query3 = "SELECT Jumlah FROM Stok WHERE Id_User = '".$ob1->getIduser()."' AND Id_Barang = '".$ob1->getIdbarang()."'";
							$exquery3 = mysql_query($query3);
							if($exquery3){
								$jum = mysql_fetch_array($exquery3);
								if(($jum[0]-$ob1->getJumlah()) >= 0){
									$query2 = "UPDATE Stok SET Jumlah = (Jumlah-'".$ob1->getJumlah()."') WHERE Id_User = '".$ob1->getIduser()."' AND Id_Barang = '".$ob1->getIdbarang()."'";
									$exquery2 = mysql_query($query2);
									if($exquery2){
										$query = "INSERT INTO `Pengiriman` SELECT (COUNT(*)+1),'".$ob1->getTanggal()."','".$ob1->getIduser()."','".$ob1->getIdtarget()."','".$ob1->getIdbarang()."','".$ob1->getJumlah()."','".$ob1->getStatus()."' FROM `Pengiriman` WHERE 1 ";
										$exquery = mysql_query($query);
										if($exquery){
											echo "Anda telah berhasil menginput data<br>";
										}
										else{
											echo "Anda tidak berhasil menginput data<br>";
										}
									}
									else{
										echo "Maaf, Stok Anda tidak memenuhi<br>";
									}
								}
								else{
									echo "Maaf, Stok Anda tidak memenuhi<br>";
								}
							}
						}
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
