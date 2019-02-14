		<?php
				include "include/koneksi.php";
				include "include/penjualan.php";
				
				if(@$_GET['id'] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$atribut = 'Id';
						$nilai = $_GET['id'];
						
						$query = "SELECT *,COUNT(*) FROM Penjualan WHERE $atribut = '$nilai' ";
						$exquery = mysql_query($query);
						if($exquery){
							$hasil = mysql_fetch_array($exquery);
							if($hasil[7] > 0){
								$query6 = "UPDATE Stok SET Jumlah = (Jumlah+".$hasil['Jumlah'].") WHERE Id_User = '".$hasil['Id_User']."' AND Id_Barang = '".$hasil['Id_Barang']."' ";
								$exquery6 = mysql_query($query6);
								if($exquery6){
									$query2 = "SELECT * FROM Penjualan WHERE $atribut = '$nilai' ";
									$exquery2 = mysql_query($query2);
									if($exquery2){
										$kueh = "DELETE FROM `Penjualan` WHERE $atribut = '$nilai' ";
										$exkueh = mysql_query($kueh);
										if($exkueh){
											while($hasil2 = mysql_fetch_array($exquery2)){
												$query3 = "SELECT COUNT(*) FROM Penjualan WHERE Id > ".$hasil2['Id'];
												$exquery3 = mysql_query($query3);
												if($exquery3){
													$hitung = mysql_fetch_array($exquery3);
													if($hitung[0] > 0){
														$query4 = "UPDATE Penjualan SET Id = (Id-1) WHERE Id > ".$hasil2['Id'];
														$exquery4 = mysql_query($query4);
														if($exquery4){
															echo "Anda telah berhasil menghapus data<br>";
														}
														else{
															echo "Anda tidak berhasil menghapus data<br>";
														}
													}
													else{
														echo "Anda telah berhasil menghapus data<br>";
													}
												}
											}
										}
										else{
											echo "Anda tidak berhasil menghapus data<br>";
										}
									}
									else{
										echo "Anda tidak berhasil menghapus data<br>";
									}
								}
							}
							else{
								echo "Anda tidak berhasil menghapus data<br>";
							}
						}
						else{
							echo "Anda tidak berhasil menghapus data<br>";
						}
								
						mysql_close($Koneksi->getKonek());
				}
			?>
		</form>
