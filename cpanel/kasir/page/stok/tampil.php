			<?php
				include "include/koneksi.php";
				
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'kirim'){
						echo "<script>window.location='?page=stok&i=kirim&id=".$_POST['identitas']."'</script>";
					}
				}	
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("bolu_pisang");
				
				$query2 = "SELECT Id FROM User WHERE Username = '".$_SESSION["username"]."' ";
				$exquery2 = mysql_query($query2);
				if($exquery2){
					$hasil = mysql_fetch_array($exquery2);			
					$query = "SELECT * FROM `Stok` WHERE Id_User = '".$hasil[0]."'";
					$exquery = mysql_query($query);
					if($exquery){
						echo "<form action='' id=daftar method=POST >";
						echo "<input type=hidden id=identitas name=identitas>";
						echo "<h3>Data - Data Stok</h3>";
						echo "<table align=center border=1 class=CSSTableGenerator>
						<tr>
							<td>Id</td><td>Id Barang</td><td>Jumlah</td><td>Aksi</td>
						</tr>";
						while($hasil = mysql_fetch_array($exquery)){
							echo "<tr>
							<td>".$hasil['Id']."</td>
							<td><a href='?page=barang'>".$hasil['Id_Barang']."</a></td>
							<td>".$hasil['Jumlah']."</td>
							<td>
								<select id='Aksi".$hasil['Id']."' name='Aksi".$hasil['Id']."' onChange=document.getElementById('Aksi".$hasil['Id']."').name='Aksi';document.getElementById('identitas').value='".$hasil['Id']."';document.getElementById('daftar').submit() >
									<option value=''>--pilih aksi--</option>
									<option value='kirim'>Kirim</option>
								</select>
							</td></tr>";
						}
						echo "</table>";
						echo "</form>";
					}
					else{
						echo "Anda tidak berhasil menampilkan data<br>";
					}
				}
				mysql_close($Koneksi->getKonek());
			?>
