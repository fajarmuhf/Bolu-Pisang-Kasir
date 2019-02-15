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
				<td>Id Barang : </td><td>
					<?php
						include "include/koneksi.php";
						
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
						
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
				include "include/penjualan.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["id_barang"] != "" && @$_POST["jumlah"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$tanggal = date("Y-m-d H:m:s");
						$kueh = "SELECT Id FROM User WHERE Username = '".$_SESSION['username']."'";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							$res = mysqli_fetch_array($exkueh);
							$id_user = $res[0];
							$id_barang = $_POST["id_barang"];
							$jumlah = $_POST["jumlah"];
							
							$ob1 = new Penjualan();
							$ob1->setTanggal($tanggal);
							$ob1->setIduser($id_user);
							$ob1->setIdbarang($id_barang);
							$ob1->setJumlah($jumlah);
							
							$query3 = "SELECT Jumlah FROM Stok WHERE Id_User = '".$ob1->getIduser()."' AND Id_Barang = '".$ob1->getIdbarang()."' ";
							$exquery3 = mysqli_query($Koneksi->getKonek(),$query3);
							if($exquery3){
								$result = mysqli_fetch_array($exquery3);
								if(($result[0]-($ob1->getJumlah())) >= 0 ){
									$juman = ($result[0]-($ob1->getJumlah()));
									$query4 = "UPDATE Stok SET Jumlah = '".$juman."' WHERE Id_User = '".$ob1->getIduser()."' AND Id_Barang = '".$ob1->getIdbarang()."' ";
									$exquery4 = mysqli_query($Koneksi->getKonek(),$query4);
									if($exquery4){
										$query2 = "SELECT Harga FROM Barang WHERE Id = '".$ob1->getIdbarang()."'";
										$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
										if($exquery2){
											$hasil = mysqli_fetch_array($exquery2);
											$total = ($ob1->getJumlah()*$hasil[0]);
											$query = "INSERT INTO `Penjualan` SELECT (COUNT(*)+1),'".$ob1->getTanggal()."','".$ob1->getIduser()."','".$ob1->getIdbarang()."','".$ob1->getJumlah()."','".$total."','".($total*2.5/100)."' FROM `Penjualan` WHERE 1 ";
											$exquery = mysqli_query($Koneksi->getKonek(),$query);
											if($exquery){
												echo "Anda telah berhasil menginput data<br>";
											}
											else{
												echo "Anda tidak berhasil menginput data<br>";
											}
										}
									}
									else{
										echo "Anda tidak berhasil menginput data<br>";
									}
								}
								else{
									echo "Maaf, Anda stok anda tidak cukup<br>";
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
