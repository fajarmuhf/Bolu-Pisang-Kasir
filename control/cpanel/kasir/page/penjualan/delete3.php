		<form action="?page=penjualan&i=delete3&kirim=1" method="post">
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
								
						$kueh = "SELECT *,COUNT(*) FROM pengiriman WHERE id = ?";
						$exquery=$Koneksi->getKonek()->prepare($kueh);
						$exquery->bind_param("i",$nilai);
						$exkueh = $exquery->execute();
						if($exkueh){
							$hasil = $exquery->get_result()->fetch_all(MYSQLI_ASSOC);
							if(true){
								$query = "DELETE FROM `pengiriman` WHERE id = ? ";
								$exquery21=$Koneksi->getKonek()->prepare($query);
								$exquery21->bind_param("i",$nilai);
								$exquery = $exquery21->execute();
								if($exquery){
									$query2 = "SELECT COUNT(*) FROM pengiriman WHERE Id > ?";
									$exquery31=$Koneksi->getKonek()->prepare($query2);
									$exquery31->bind_param("i",$nilai);
									$exquery2 = $exquery31->execute();
									if($exquery2){
										$hitung = $exquery31->get_result()->fetch_all(MYSQLI_ASSOC);
										if($hitung[0]['COUNT(*)'] > 0){
											$query3 = "UPDATE pengiriman SET Id = (Id-1) WHERE Id > ?";
											$exquery32=$Koneksi->getKonek()->prepare($query3);
											$exquery32->bind_param("i",$nilai);
											$exquery3 = $exquery32->execute();
											if($exquery3){
												$totalid = $hasil[0]["COUNT(*)"]+1;
												$reset = "ALTER TABLE pengiriman AUTO_INCREMENT = $totalid";
												$exquery4 = $Koneksi->getKonek()->query($reset);
												if($exquery4){

													$n = $hasil[0]["itemid"];
													$j = $hasil[0]["jumlah"];
											
													$query = "UPDATE produk SET stock = stock-? WHERE id = ? ";
													$exquery21=$Koneksi->getKonek()->prepare($query);
													$exquery21->bind_param("ii",$j,$n);
													$exquery = $exquery21->execute();

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
													   window.location = 'kasir.php?page=penjualan&i=pengiriman';
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
											$totalid = $hasil[0]["COUNT(*)"]+1;
											$reset = "ALTER TABLE pengiriman AUTO_INCREMENT = $totalid";
											$exquery4 = $Koneksi->getKonek()->query($reset);
											if($exquery4){

												$n = $hasil[0]["itemid"];
												$j = $hasil[0]["jumlah"];
										
												$query = "UPDATE produk SET stock = stock-? WHERE id = ? ";
												$exquery21=$Koneksi->getKonek()->prepare($query);
												$exquery21->bind_param("ii",$j,$n);
												$exquery = $exquery21->execute();

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
												   window.location = 'kasir.php?page=penjualan&i=pengiriman';
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
