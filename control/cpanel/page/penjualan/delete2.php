		<form action="?page=penjualan&i=delete2&kirim=1" method="post">
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
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi->Konek("fandystore");
								
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];

						$kuehz = "SELECT * FROM clientorder as A,cart as B WHERE A.id = ? AND A.id = B.orderid";
						$exqueryz=$Koneksi->getKonek()->prepare($kuehz);
						$exqueryz->bind_param("i",$nilai);
						$exkuehz = $exqueryz->execute();
						if($exkuehz){
							$hasilk = $exqueryz->get_result()->fetch_all(MYSQLI_ASSOC);
							
							for($i=0;$i<count($hasilk);$i++){
								
								$n = $hasilk[$i]["itemid"];
								$j = $hasilk[$i]["jumlah"];

								$querys = "UPDATE produk SET stock = stock+? WHERE id = ? ";
								$exquerys21=$Koneksi->getKonek()->prepare($querys);
								$exquerys21->bind_param("ii",$j,$n);
								$exquerys = $exquerys21->execute();
								if($exquerys){
								}
								else{
								}
							}
							if(count($hasilk)==0){
							}
						}

						$kueh = "SELECT * FROM cart WHERE orderid = ?";
						$exquery=$Koneksi->getKonek()->prepare($kueh);
						$exquery->bind_param("i",$nilai);
						$exkueh = $exquery->execute();
						if($exkueh){
							$hasil = $exquery->get_result()->fetch_all(MYSQLI_ASSOC);
							for($i=0;$i<count($hasil);$i++){
								$n = $hasil[$i]["id"];
								$query = "DELETE FROM `cart` WHERE id = ? ";
								$exquery21=$Koneksi->getKonek()->prepare($query);
								$exquery21->bind_param("i",$n);
								$exquery = $exquery21->execute();
								if($exquery){
									
								}
							}
						}
						$query2 = "SELECT COUNT(*) FROM cart WHERE id > ?";
						$exquery31=$Koneksi->getKonek()->prepare($query2);
						$exquery31->bind_param("i",$n);
						$exquery2 = $exquery31->execute();
						if($exquery2){
							$hitung = $exquery31->get_result()->fetch_all(MYSQLI_ASSOC);
							if($hitung[0]['COUNT(*)'] > 0){
								$query3 = "UPDATE cart SET id = (id-1) WHERE id > ?";
								$exquery32=$Koneksi->getKonek()->prepare($query3);
								$exquery32->bind_param("i",$n);
								$exquery3 = $exquery32->execute();
								if($exquery3){
									$jumlahclientorder = $hitung[0]['COUNT(*)']+1;
									$query4 = "ALTER TABLE cart AUTO_INCREMENT=$jumlahclientorder";
									$exquery42=mysqli_query($Koneksi->getKonek(),$query4);
								}

							}
							else{
								$jumlahclientorder = $hitung[0]['COUNT(*)']+1;
								$query4 = "ALTER TABLE cart AUTO_INCREMENT=$jumlahclientorder";
								$exquery42=mysqli_query($Koneksi->getKonek(),$query4);
							}
						}
														
						$kueh = "SELECT *,COUNT(*) FROM clientorder WHERE id = ?";
						$exquery=$Koneksi->getKonek()->prepare($kueh);
						$exquery->bind_param("i",$nilai);
						$exkueh = $exquery->execute();
						if($exkueh){
							$hasil = $exquery->get_result()->fetch_all(MYSQLI_ASSOC);
							if(true){
								$query = "DELETE FROM `clientorder` WHERE id = ? ";
								$exquery21=$Koneksi->getKonek()->prepare($query);
								$exquery21->bind_param("i",$nilai);
								$exquery = $exquery21->execute();
								if($exquery){
									$query2 = "SELECT COUNT(*) FROM clientorder WHERE id > ?";
									$exquery31=$Koneksi->getKonek()->prepare($query2);
									$exquery31->bind_param("i",$nilai);
									$exquery2 = $exquery31->execute();
									if($exquery2){
										$hitung = $exquery31->get_result()->fetch_all(MYSQLI_ASSOC);
										if($hitung[0]['COUNT(*)'] > 0){
											$query3 = "UPDATE clientorder SET id = (id-1) WHERE id > ?";
											$exquery32=$Koneksi->getKonek()->prepare($query3);
											$exquery32->bind_param("i",$nilai);
											$exquery3 = $exquery32->execute();
											if($exquery3){
												$jumlahclientorder = $hitung[0]['COUNT(*)']+1;
												$query4 = "ALTER TABLE clientorder AUTO_INCREMENT=$jumlahclientorder";
												$exquery42=mysqli_query($Koneksi->getKonek(),$query4);
												if($exquery42){
													$query5 = "UPDATE cart SET orderid = (orderid-1) WHERE orderid > ? ";
													$exquery52=$Koneksi->getKonek()->prepare($query5);
													$exquery52->bind_param("i",$nilai);
													$exquery5 = $exquery52->execute();
													if($exquery5){
														echo "<script>Swal.fire({
														    toast: true,
														    icon: 'success',
														    title: 'Sukses',
														    animation: false,
														    position: 'bottom',
														    showConfirmButton: false,
														    timer: 3000,
														    timerProgressBar: true,
														    didOpen: (toast) => {
														      toast.addEventListener('mouseenter', Swal.stopTimer)
														      toast.addEventListener('mouseleave', Swal.resumeTimer)
														    }
														  }).then(() => {
															   window.location = 'admin.php?page=penjualan&i=history';
														  })</script>";
													}
													else{
														echo "<script>Swal.fire({
													    toast: true,
													    icon: 'error',
													    title: 'Gagal',
													    animation: false,
													    position: 'bottom',
													    showConfirmButton: false,
													    timer: 3000,
													    timerProgressBar: true,
													    didOpen: (toast) => {
													      toast.addEventListener('mouseenter', Swal.stopTimer)
													      toast.addEventListener('mouseleave', Swal.resumeTimer)
													    }
													  })</script>";
													}
												}
												else{
													echo "<script>Swal.fire({
												    toast: true,
												    icon: 'error',
												    title: 'Gagal',
												    animation: false,
												    position: 'bottom',
												    showConfirmButton: false,
												    timer: 3000,
												    timerProgressBar: true,
												    didOpen: (toast) => {
												      toast.addEventListener('mouseenter', Swal.stopTimer)
												      toast.addEventListener('mouseleave', Swal.resumeTimer)
												    }
												  })</script>";
												}
											}
											else{
												echo "<script>Swal.fire({
												    toast: true,
												    icon: 'error',
												    title: 'Gagal',
												    animation: false,
												    position: 'bottom',
												    showConfirmButton: false,
												    timer: 3000,
												    timerProgressBar: true,
												    didOpen: (toast) => {
												      toast.addEventListener('mouseenter', Swal.stopTimer)
												      toast.addEventListener('mouseleave', Swal.resumeTimer)
												    }
												  })</script>";
											}
										}
										else{
											$jumlahclientorder = $hitung[0]['COUNT(*)']+1;
											$query4 = "ALTER TABLE clientorder AUTO_INCREMENT=$jumlahclientorder";
											$exquery42=mysqli_query($Koneksi->getKonek(),$query4);
											
											echo "<script>Swal.fire({
										    toast: true,
										    icon: 'success',
										    title: 'Sukses',
										    animation: false,
										    position: 'bottom',
										    showConfirmButton: false,
										    timer: 3000,
										    timerProgressBar: true,
										    didOpen: (toast) => {
										      toast.addEventListener('mouseenter', Swal.stopTimer)
										      toast.addEventListener('mouseleave', Swal.resumeTimer)
										    }
										  }).then(() => {
											   window.location = 'admin.php?page=penjualan&i=history';
										  })</script>";
										}
									}
								}
								else{
									echo "<script>Swal.fire({
								    toast: true,
								    icon: 'error',
								    title: 'Gagal',
								    animation: false,
								    position: 'bottom',
								    showConfirmButton: false,
								    timer: 3000,
								    timerProgressBar: true,
								    didOpen: (toast) => {
								      toast.addEventListener('mouseenter', Swal.stopTimer)
								      toast.addEventListener('mouseleave', Swal.resumeTimer)
								    }
								  })</script>";
								}
							}
						}
					}
				}
			?>
		</form>
