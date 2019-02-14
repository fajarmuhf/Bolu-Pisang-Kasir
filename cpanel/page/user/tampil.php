			<?php
				include "include/koneksi.php";
				
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'edit'){
						echo "<script>window.location='?page=user&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else{
						echo "<script>window.location='?page=user&i=delete&id=".$_POST['identitas']."'</script>";
					}
				}				
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("bolu_pisang");
								
				$query = "SELECT * FROM `user` WHERE 1 ";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<h3>Data - Data User</h3>";
					echo "<table align=center border=1 class=CSSTableGenerator >
					<tr>
						<td>Id</td><td>Username</td><td>Password</td><td>Status</td><td>Aksi</td>
					</tr>";
					while($hasil = mysqli_fetch_array($exquery)){
						echo "<tr>
						<td>".$hasil['Id']."</td>
						<td>".$hasil['Username']."</td>
						<td>".$hasil['Password']."</td>
						<td>".$hasil['Status']."</td>
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
					echo "</form>";
				}
				else{
					echo "Anda tidak berhasil menampilkan data<br>";
				}
				mysqli_close($Koneksi->getKonek());
			?>
