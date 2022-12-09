<?php
				include "../include/koneksi.php";
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("penjualan_mobil");
								
				$username = $_SESSION["username"];
						
				$kueh = "SELECT Id FROM `User` WHERE Username = '$username' ";
				$exkueh = mysql_query($kueh);
				if($exkueh){
					$id = mysql_fetch_array($exkueh);
					$query = "SELECT * FROM `Penjualan` WHERE Id_User = ".$id[0]." ";
					$exquery = mysql_query($query);
					if($exquery){
						echo "<h3>Data - Data Mobil yang telah anda beli</h3>";
						echo "<table align=center border=1 class='CSSTableGenerator'>
						<tr>
							<td>Id Mobil</td><td>Quantity</td>
						</tr>";
						while($hasil = mysql_fetch_array($exquery)){
							$query2 = "SELECT Gambar FROM Mobil WHERE Id = ".$hasil['Id_Mobil'];
							$exquery2 = mysql_query($query2);
							$gambar = mysql_fetch_array($exquery2);
							echo "<tr>
							<td><a href='upload/".$gambar[0]."'  onclick='return hs.expand(this)' class='highslide'><img src='upload/".$gambar[0]."' width=120px height=120px ></a></td>
							<td>".$hasil['Quantity']."</td>
							</tr>";
						}
						echo "</table>";
					}
					else{
						echo "Anda tidak berhasil menampilkan data<br>";
					}
				}
				else{
					echo "Username tidak tersedia";
				}
				mysql_close($Koneksi->getKonek());
			?>
