			<?php
				include "include/koneksi.php";
				
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'terima'){
						echo "<script>window.location='?page=stok&i=validcek&id=".$_POST['identitas']."&status=diterima'</script>";
					}
					else{
						echo "<script>window.location='?page=stok&i=validcek&id=".$_POST['identitas']."&status=dibatalkan'</script>";
					}
				}
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("bolu_pisang");
				
				$query2 = "SELECT Id FROM User WHERE Username = '".$_SESSION["username"]."'";
				$exquery2 = mysql_query($query2);
				if($exquery2){
					$hasil = mysql_fetch_array($exquery2);							
					$query = "SELECT * FROM `Pengiriman` WHERE Id_Target = '".$hasil[0]."' ORDER BY Tanggal";
					$exquery = mysql_query($query);
					if($exquery){
						echo "<form action='' id=daftar method=POST >";
						echo "<input type=hidden id=identitas name=identitas>";
						echo "<h3>Data - Data Penerimaan</h3>";
						echo "<table align=center border=1 class=CSSTableGenerator >
						<tr>
							<td>Id</td><td>Tanggal</td><td>Id Pengirim</td><td>Id Barang</td><td>Jumlah</td><td>Status</td><td>Aksi</td>
						</tr>";
						while($hasil = mysql_fetch_array($exquery)){
							echo "<tr>
							<td>".$hasil['Id']."</td>
							<td>".$hasil['Tanggal']."</td>
							<td><a href='?page=user'>".$hasil['Id_User']."</a></td>
							<td><a href='?page=barang'>".$hasil['Id_Barang']."</a></td>
							<td>".$hasil['Jumlah']."</td>
							<td>".$hasil['Status']."</td>
							";
							if($hasil['Status'] == 'tertunda'){
								echo "<td>
								<select id='Aksi".$hasil['Id']."' name='Aksi".$hasil['Id']."' onChange=document.getElementById('Aksi".$hasil['Id']."').name='Aksi';document.getElementById('identitas').value='".$hasil['Id']."';document.getElementById('daftar').submit() >
									<option value=''>--pilih aksi--</option>
									<option value='terima'>Terima</option>
									<option value='batal'>Batal</option>
								</select>
								</td>";
							}
							else{
								echo "<td></td>";
							}
							echo "</tr>";
						}
						echo "</table>";
					}
					else{
						echo "Anda tidak berhasil menampilkan data<br>";
					}
				}
				mysql_close($Koneksi->getKonek());
			?>
