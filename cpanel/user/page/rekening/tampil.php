			<?php
				include "include/koneksi.php";
				
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'edit'){
						echo "<script>window.location='?page=rekening&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else{
						echo "<script>window.location='?page=rekening&i=delete&id=".$_POST['identitas']."'</script>";
					}
				}
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("penjualan_mobil");
								
				$query = "SELECT * FROM `Rekening` WHERE 1 ";
				$exquery = mysql_query($query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<h3>Data - Data Rekening</h3>";
					echo "<table align=center border=1 class=CSSTableGenerator >
					<tr>
						<td>Id</td><td>Id_User</td><td>Saldo</td><td>Aksi</td>
					</tr>";
					while($hasil = mysql_fetch_array($exquery)){
						echo "<tr>
						<td>".$hasil['Id']."</td>
						<td>".$hasil['Id_User']."</td>
						<td>".$hasil['Saldo']."</td>
						<td>
							<select id='Aksi".$hasil['Id']."' name='Aksi".$hasil['Id']."' onChange=document.getElementById('Aksi".$hasil['Id']."').name='Aksi';document.getElementById('identitas').value='".$hasil['Id']."';document.getElementById('daftar').submit() >
								<option value=''>--pilih aksi--</option>
								<option value='edit'>Edit</option>
								<option value='hapus'>Hapus</option>
							</select>
						</td>
						</tr>";
					}
					echo "</table>";
				}
				else{
					echo "Anda tidak berhasil menampilkan data<br>";
				}
				mysql_close($Koneksi->getKonek());
			?>
