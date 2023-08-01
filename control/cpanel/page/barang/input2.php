		<form action="?page=barang&i=input2&kirim=1" method="post" enctype="multipart/form-data">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Tambah</td>
			</tr>
			<tr>
				<td>Cabang 1 : </td><td><select name="perum" id="perum">
					<?php
						$Koneksi->Konek("fandystore");
						
						$username = $_SESSION['username'];
						$password = $_SESSION["password"];

						$query="SELECT Id,Perum FROM `user-manager` WHERE Username = ? AND Password = ?";

						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$username,$password);
						$exquery->execute();
						
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
							$perumold = $tampil[0]["Perum"];
						}

						$kueh = "SELECT * FROM `perumahan` WHERE 1 ";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							while($hasilkueh = mysqli_fetch_array($exkueh)){
								$perumahan = $hasilkueh["nama"];
								if(strcmp($perumold, $perumahan) == 0){
									echo "<option value='$perumahan' selected>$perumahan</option>";
								}
								else{
									echo "<option value='$perumahan'>$perumahan</option>";
								}
							}
						}
					?>
				</select></td>
			</tr>
			<tr>
				<td>Cabang 2 : </td><td><select name="perum2" id="perum2">
					<?php
						$Koneksi->Konek("fandystore");
						
						$username = $_SESSION['username'];
						$password = $_SESSION["password"];

						$query="SELECT Id,Perum FROM `user-manager` WHERE Username = ? AND Password = ?";

						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$username,$password);
						$exquery->execute();
						
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
							$perumold = $tampil[0]["Perum"];
						}

						$kueh = "SELECT * FROM `perumahan` WHERE 1 ";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							while($hasilkueh = mysqli_fetch_array($exkueh)){
								$perumahan = $hasilkueh["nama"];
								if(strcmp($perumold, $perumahan) == 0){
									echo "<option value='$perumahan' selected>$perumahan</option>";
								}
								else{
									echo "<option value='$perumahan'>$perumahan</option>";
								}
							}
						}
					?>
				</select></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/barang.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["perum"] != "" && @$_POST["perum2"] != ""){
						$perum = $_POST["perum"];
						$perum2 = $_POST["perum2"];
							
						$kueh = "SELECT * FROM `produk` WHERE perum = ? ";
						$exquery=$Koneksi->getKonek()->prepare($kueh);
						$exquery->bind_param("s",$perum);
						$result = $exquery->execute();
						if($result){
							$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							for($i=0;$i<count($hasil);$i++){	
								$nama_produk = $hasil[$i]["nama"];
								$deskripsi = $hasil[$i]["deskripsi"];
								$stok = $hasil[$i]["stock"];
								$satuan = $hasil[$i]["satuan"];
								$modal = $hasil[$i]["modal"];
								$harga = $hasil[$i]["harga"];
								$tag = $hasil[$i]["tag"];
								$gambar = $hasil[$i]["imageurl"];
								$expire = $hasil[$i]["expdate"];
								$barcode = $hasil[$i]["barcode"];


								$ketemu = false;
								
								$kueh2 = "SELECT * FROM `produk` WHERE perum = ? ";
								$exquery2=$Koneksi->getKonek()->prepare($kueh2);
								$exquery2->bind_param("s",$perum2);
								$exquery2->execute();
								$hasil2=$exquery2->get_result()->fetch_all(MYSQLI_ASSOC);
								for($j=0;$j<count($hasil2);$j++){					
									$nama_produk2 = $hasil2[$j]["nama"];
									
									if(strcmp($nama_produk,$nama_produk2) == 0){
										$ketemu = true;
									}
								}

								if(!$ketemu){
									echo "INSERT INTO `produk` SELECT (COUNT(*)+1),'$nama_produk','$deskripsi','$stok','$satuan','$modal','$harga','$perum2','$tag',0,'$gambar','$expire','$barcode' FROM `produk` WHERE 1 ";
									$query3 = "INSERT INTO `produk` SELECT (COUNT(*)+1),?,?,?,?,?,?,?,?,0,?,?,? FROM `produk` WHERE 1 ";
									$exquery3=$Koneksi->getKonek()->prepare($query3);
									$exquery3->bind_param("ssisiisssss",$nama_produk,$deskripsi,$stok,$satuan,$modal,$harga,$perum2,$tag,$gambar,$expire,$barcode);
									$exquery3->execute();
								}

							}
							echo "Anda telah berhasil menginput data<br>";
						}

						mysqli_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
