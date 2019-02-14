		<form action="?page=mentah&i=delete&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Delete</td>
			</tr>
			<tr>
				<td>Atribut : </td>
				<td>
					<select name="atribut" id="atribut">
						<option value="Id">Id</option>
						<option value="Nama">Nama</option>
						<option value="Keterangan">Keterangan</option>
						<option value="Tahun">Tahun</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Nilai : </td><td><input type="text" name="nilai" id="nilai"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Hapus </button></td>
			</tr>
			</table>
			<?php
				include "include/koneksi.php";
				include "include/barang.php";
				
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
								
						$kueh = "SELECT * FROM Barang_Mentah WHERE $atribut = '$nilai'";
						$exkueh = mysql_query($kueh);
						if($exkueh){
							while($hasil = mysql_fetch_array($exkueh)){
								$query = "DELETE FROM `Barang_Mentah` WHERE $atribut = '$nilai' ";
								$exquery = mysql_query($query);
								if($exquery){
									unlink("upload/".$hasil['Gambar']);
									$query2 = "SELECT COUNT(*) FROM Barang_Mentah WHERE Id > ".$hasil['Id'];
									$exquery2 = mysql_query($query2);
									if($exquery2){
										$hitung = mysql_fetch_array($exquery2);
										if($hitung[0] > 0){
											$query3 = "UPDATE Barang_Mentah SET Id = (Id-1) WHERE Id > ".$hasil['Id'];
											$exquery3 = mysql_query($query3);
											if($exquery3){
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
								else{
									echo "Anda tidak berhasil menghapus data<br>";
								}
							}
						}
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
