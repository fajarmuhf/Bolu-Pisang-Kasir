		<script>
		  $(function() {
			$( "#tanggal" ).datetimepicker();
		  });
		</script>
		<?php
			echo "<form action='?page=penjualan&i=edit&kirim=1&id=".$_GET['id']."' method='post'>";
		?>
			<table align=center class=Login>
			<tr>
				<td colspan=2>Edit</td>
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
				include "include/koneksi.php";
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["jumlah"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$atribut = 'Id';
						$nilai = $_GET['id'];
								
						$tanggal = date("Y-m-d H:m:s");
						$kueh = "SELECT Id FROM User WHERE Username = '".$_SESSION['username']."'";
						$exkueh = mysql_query($kueh);
						if($exkueh){
							$res = mysql_fetch_array($exkueh);
							$id_user = $res[0];
							
							$query6 = "SELECT Id_Barang FROM Penjualan WHERE $atribut = '$nilai' ";
							$exquery6 = mysql_query($query6);
							
							if($exquery6){
								$tempBarang = mysql_fetch_array($exquery6);
								
								$id_barang = $tempBarang[0];
								$jumlah = $_POST["jumlah"];
								
								$ob1 = new Penjualan();
								$ob1->setTanggal($tanggal);
								$ob1->setIduser($id_user);
								$ob1->setIdbarang($id_barang);
								$ob1->setJumlah($jumlah);
								
								$query3 = "SELECT Jumlah FROM Stok WHERE Id_User = '".$ob1->getIduser()."' AND Id_Barang = '".$ob1->getIdbarang()."' ";
								$exquery3 = mysql_query($query3);
								if($exquery3){
									$result = mysql_fetch_array($exquery3);
									$query5 = "SELECT Jumlah FROM `Penjualan` WHERE $atribut = '$nilai' ";
									$exquery5 = mysql_query($query5);
										if($exquery5){
											$tempjum = mysql_fetch_array($exquery5);
											$juman = ($result[0]+$tempjum[0] - ($ob1->getJumlah()));
											if($juman >= 0 ){
												$query4 = "UPDATE Stok SET Jumlah = '".$juman."' WHERE Id_User = '".$ob1->getIduser()."' AND Id_Barang = '".$ob1->getIdbarang()."' ";
												$exquery4 = mysql_query($query4);
												if($exquery4){
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
												}
												else{
													echo "Anda tidak berhasil mengedit data<br>";
												}
											}
											else{
												echo "Maaf, Stok Anda tidak mencukupi<br>";
											}
									}
								}
								else{
									echo "Anda tidak berhasil mengedit data<br>";
								}
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
