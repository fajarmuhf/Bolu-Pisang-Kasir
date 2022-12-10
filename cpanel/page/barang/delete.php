<?php
	include "page/secure.php";			
?>
		<form action="?page=barang&i=delete&kirim=1" method="post">
			<input type="hidden" name="atribut" id="atribut" value="id">
			<input type="hidden" name="nilai" id="nilai">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Delete</td>
			</tr>
			<tr>
				<td colspan="2">Yakin ingin menghapus ?.</td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Hapus </button></td>
			</tr>
			</table>
			<?php
				include "include/barang.php";
				
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("fandystore");
								
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
								
						$kueh = "SELECT *,COUNT(*) FROM produk WHERE id = ?";
						$exquery=$Koneksi->getKonek()->prepare($kueh);
						$exquery->bind_param("i",$nilai);
						$exkueh = $exquery->execute();
						if($exkueh){
							$hasil = $exquery->get_result()->fetch_all(MYSQLI_ASSOC);
							if(true){
								$query = "DELETE FROM `produk` WHERE id = ? ";
								$exquery21=$Koneksi->getKonek()->prepare($query);
								$exquery21->bind_param("i",$nilai);
								$exquery = $exquery21->execute();
								if($exquery){
									unlink("../../images/".$hasil[0]['imageurl']);
									$query2 = "SELECT COUNT(*) FROM produk WHERE Id > ?";
									$exquery31=$Koneksi->getKonek()->prepare($query2);
									$exquery31->bind_param("i",$nilai);
									$exquery2 = $exquery31->execute();
									if($exquery2){
										$hitung = $exquery31->get_result()->fetch_all(MYSQLI_ASSOC);
										if($hitung[0]['COUNT(*)'] > 0){
											$query3 = "UPDATE produk SET Id = (Id-1) WHERE Id > ?";
											$exquery32=$Koneksi->getKonek()->prepare($query3);
											$exquery32->bind_param("i",$nilai);
											$exquery3 = $exquery32->execute();
											if($exquery3){
												$totalid = $hasil[0]["COUNT(*)"]+1;
												$query4 = "ALTER TABLE produk AUTO_INCREMENT=?";
												$exquery42=$Koneksi->getKonek()->prepare($query4);
												$exquery42->bind_param("i",$totalid);
												$exquery4 = $exquery42->execute();
												if($exquery4){
													echo "Anda telah berhasil menghapus data<br>";
												}
												else{
													echo "Anda tidak berhasil menghapus data<br>";
												}
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
					}
				}
			?>
		</form>
