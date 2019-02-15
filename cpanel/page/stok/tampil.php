			<?php
				include "include/koneksi.php";
				
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'edit'){
						echo "<script>window.location='?page=stok&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else{
						echo "<script>window.location='?page=stok&i=delete&id=".$_POST['identitas']."'</script>";
					}
				}	
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("bolu_pisang");
								
				$query = "SELECT * FROM `Stok` WHERE 1 ";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<h3>Data - Data Stok</h3>";
					echo "<table align=center border=1 class=CSSTableGenerator>
					<tr>
						<td>Id</td><td>Id User</td><td>Id Barang</td><td>Jumlah</td><td>Aksi</td>
					</tr>";
					while($hasil = mysqli_fetch_array($exquery)){
						echo "<tr>
						<td>".$hasil['Id']."</td>
						<td><a href='?page=user'>".$hasil['Id_User']."</a></td>
						<td><a href='?page=barang'>".$hasil['Id_Barang']."</a></td>
						<td>".$hasil['Jumlah']."</td>
						<td>
							<select id='Aksi".$hasil['Id']."' name='Aksi".$hasil['Id']."' onChange=document.getElementById('Aksi".$hasil['Id']."').name='Aksi';document.getElementById('identitas').value='".$hasil['Id']."';document.getElementById('daftar').submit() >
								<option value=''>--pilih aksi--</option>
								<option value='edit'>Edit</option>
								<option value='hapus'>Hapus</option>
							</select>
						</td></tr>";
					}
					echo "</table>";
					echo "</form>";
				}
				else{
					echo "Anda tidak berhasil menampilkan data<br>";
				}
				mysqli_close($Koneksi->getKonek());
			?>
