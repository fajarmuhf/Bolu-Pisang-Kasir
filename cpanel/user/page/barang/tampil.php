			<?php
				include "include/koneksi.php";
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'edit'){
						echo "<script>window.location='?page=barang&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else{
						echo "<script>window.location='?page=barang&i=delete&id=".$_POST['identitas']."'</script>";
					}
				}				
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("bolu_pisang");
								
				$query = "SELECT * FROM `Barang` WHERE 1 ";
				$exquery = mysql_query($query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<h3>Data - Data Barang</h3>";
					echo "<table align=center border=1 class=CSSTableGenerator >
					<tr>
						<td>Id</td><td>Nama</td><td>Harga</td><td>Keterangan</td><td>Gambar</td>
					
					</tr>";
					while($hasil = mysql_fetch_array($exquery)){
						echo "<tr>
						<td>".$hasil['Id']."</td>
						<td>".$hasil['Nama']."</td>
						<td>".$hasil['Harga']."</td>
						<td>".$hasil['Keterangan']."</td>";
						if($hasil['Gambar'] != ''){
						echo "<td><a href='upload/".$hasil['Gambar']."'  onclick='return hs.expand(this)' class='highslide'><img src='upload/".$hasil['Gambar']."' width=120px height=120px ></a></td>
						</tr>";
						}
						else{
							echo "<td></td>
						<td>
							<select id='Aksi".$hasil['Id']."' name='Aksi".$hasil['Id']."' onChange=document.getElementById('Aksi".$hasil['Id']."').name='Aksi';document.getElementById('identitas').value='".$hasil['Id']."';document.getElementById('daftar').submit() >
								<option value=''>--pilih aksi--</option>
								<option value='edit'>Edit</option>
								<option value='hapus'>Hapus</option>
							</select>
						</td>
						</tr>";
						}
					}
					echo "</table>";
					echo "</form>";
				}
				else{
					echo "Anda tidak berhasil menampilkan data<br>";
				}
				mysql_close($Koneksi->getKonek());
				
				
			?>
