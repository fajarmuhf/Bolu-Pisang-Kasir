			<script>
				  $(function() {
					$( ".tanggal" ).datepicker();
				  });
				  function cekTanggal(){
					  if(document.getElementById('tglafter').value != ''){
						 document.getElementById('daftar').submit(); 
					  }
				  }
			</script>
			<?php
				include "page/secure.php";
				
				$Koneksi->Konek("fandystore");
				$namapage = "penjualan";
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'edit'){
						echo "<script>window.location='?page=$namapage&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else if($_POST['Aksi'] == 'input'){
						$username = $_SESSION['username'];
						$password = $_SESSION['password'];
						$itemid = $_POST['identitas'];
						$banyakitem = $_POST['banyakitem'];
						$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$username,$password);
						$exquery->execute();
						$tanggal = date("Y-m-d H:i:s");
						$tanggaldate = $_SESSION['tglafter'];
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
						}
						$query2 = "SELECT id,itemid,jumlah,COUNT(*) FROM `keluar` WHERE itemid = $itemid AND usermanagerid = $iduser AND tanggal = '$tanggaldate'";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$jumlahcart = $hasil2["jumlah"];
								$itemid = $hasil2["itemid"];
								if($banyakitem > 0){
									$query = "UPDATE `keluar` SET jumlah = ?,tanggal = ? WHERE id = ? ";
									$exquery=$Koneksi->getKonek()->prepare($query);
									$exquery->bind_param("isi",$banyakitem,$tanggaldate,$idcart);
									$result = $exquery->execute();
									if($result){

										$j = $jumlahcart-$banyakitem;
										$n = $itemid;

										$query = "UPDATE produk SET stock = stock+? WHERE id = ? ";
										$exquery21=$Koneksi->getKonek()->prepare($query);
										$exquery21->bind_param("ii",$j,$n);
										$exquery = $exquery21->execute();

										$query = "SELECT * FROM produk WHERE id = ? ";
										$exquery21=$Koneksi->getKonek()->prepare($query);
										$exquery21->bind_param("i",$n);
										$exquery21->execute();

										$tampil21=$exquery21->get_result()->fetch_all(MYSQLI_ASSOC);

										$namaproduk = $tampil21[0]["nama"];
										$stocknow = $tampil21[0]["stock"];

										if($stocknow < 10){

											echo "<script>

											jQuery.ajax({
												url:'../send.php',
												data:'stock=$stocknow&nama=$namaproduk',
												type:'post',
												success:function(result){

												}
											});

											</script>";
										}

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
						}
					}
					else if($_POST['Aksi'] == 'minus'){
						$username = $_SESSION['username'];
						$password = $_SESSION['password'];
						$itemid = $_POST['identitas'];
						$banyakitem = 1;
						$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$username,$password);
						$exquery->execute();
						$tanggal = date("Y-m-d H:i:s");
						$tanggaldate = $_SESSION['tglafter'];
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
						}
						$query2 = "SELECT id,jumlah,itemid,COUNT(*) FROM `keluar` WHERE itemid = $itemid AND usermanagerid = $iduser AND tanggal = '$tanggaldate'";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$jumlahcart = $hasil2["jumlah"];
								$itemid = $hasil2["itemid"];
								if($jumlahcart == 1){
									$nilai = $idcart;
									$query = "DELETE FROM `keluar` WHERE id = ? ";
									$exquery21=$Koneksi->getKonek()->prepare($query);
									$exquery21->bind_param("i",$nilai);
									$exquery = $exquery21->execute();
									if($exquery){
										$query2 = "SELECT COUNT(*) FROM keluar WHERE Id > ?";
										$exquery31=$Koneksi->getKonek()->prepare($query2);
										$exquery31->bind_param("i",$nilai);
										$exquery2 = $exquery31->execute();
										if($exquery2){
											$hitung = $exquery31->get_result()->fetch_all(MYSQLI_ASSOC);
											if($hitung[0]['COUNT(*)'] > 0){
												$query3 = "UPDATE keluar SET Id = (Id-1) WHERE Id > ?";
												$exquery32=$Koneksi->getKonek()->prepare($query3);
												$exquery32->bind_param("i",$nilai);
												$exquery3 = $exquery32->execute();
												if($exquery3){
													$totalid = $hitung[0]["COUNT(*)"]+1;
													$reset = "ALTER TABLE keluar AUTO_INCREMENT = $totalid";
													$exquery4 = $Koneksi->getKonek()->query($reset);
													if($exquery4){
														$j = $banyakitem;
														$n = $itemid;

														$query = "UPDATE produk SET stock = stock+? WHERE id = ? ";
														$exquery21=$Koneksi->getKonek()->prepare($query);
														$exquery21->bind_param("ii",$j,$n);
														$exquery = $exquery21->execute();

														$query = "SELECT * FROM produk WHERE id = ? ";
														$exquery21=$Koneksi->getKonek()->prepare($query);
														$exquery21->bind_param("i",$n);
														$exquery21->execute();

														$tampil21=$exquery21->get_result()->fetch_all(MYSQLI_ASSOC);

														$namaproduk = $tampil21[0]["nama"];
														$stocknow = $tampil21[0]["stock"];

														if($stocknow < 10){

															echo "<script>

															jQuery.ajax({
																url:'../send.php',
																data:'stock=$stocknow&nama=$namaproduk',
																type:'post',
																success:function(result){

																}
															});

															</script>";
														}

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
														   //window.location = 'kasir.php?page=penjualan&i=retur';
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
												$totalid = $hitung[0]["COUNT(*)"]+1;
												$reset = "ALTER TABLE pengiriman AUTO_INCREMENT = $totalid";
												$exquery4 = $Koneksi->getKonek()->query($reset);
												if($exquery4){

													$j = $banyakitem;
													$n = $itemid;

													$query = "UPDATE produk SET stock = stock+? WHERE id = ? ";
													$exquery21=$Koneksi->getKonek()->prepare($query);
													$exquery21->bind_param("ii",$j,$n);
													$exquery = $exquery21->execute();

													$query = "SELECT * FROM produk WHERE id = ? ";
													$exquery21=$Koneksi->getKonek()->prepare($query);
													$exquery21->bind_param("i",$n);
													$exquery21->execute();

													$tampil21=$exquery21->get_result()->fetch_all(MYSQLI_ASSOC);

													$namaproduk = $tampil21[0]["nama"];
													$stocknow = $tampil21[0]["stock"];

													if($stocknow < 10){

														echo "<script>

														jQuery.ajax({
															url:'../send.php',
															data:'stock=$stocknow&nama=$namaproduk',
															type:'post',
															success:function(result){

															}
														});

														</script>";
													}

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
													   //window.location = 'kasir.php?page=penjualan&i=retur';
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
								else{
									$query = "UPDATE `keluar` SET jumlah = jumlah - ?,tanggal = ? WHERE id = ? ";
									$exquery=$Koneksi->getKonek()->prepare($query);
									$exquery->bind_param("isi",$banyakitem,$tanggaldate,$idcart);
									$result = $exquery->execute();
									if($result){

										$j = $banyakitem;
										$n = $itemid;

										$query = "UPDATE produk SET stock = stock+? WHERE id = ? ";
										$exquery21=$Koneksi->getKonek()->prepare($query);
										$exquery21->bind_param("ii",$j,$n);
										$exquery = $exquery21->execute();

										$query = "SELECT * FROM produk WHERE id = ? ";
										$exquery21=$Koneksi->getKonek()->prepare($query);
										$exquery21->bind_param("i",$n);
										$exquery21->execute();

										$tampil21=$exquery21->get_result()->fetch_all(MYSQLI_ASSOC);

										$namaproduk = $tampil21[0]["nama"];
										$stocknow = $tampil21[0]["stock"];

										if($stocknow < 10){

											echo "<script>

											jQuery.ajax({
												url:'../send.php',
												data:'stock=$stocknow&nama=$namaproduk',
												type:'post',
												success:function(result){

												}
											});

											</script>";
										}

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
					}
					else if($_POST['Aksi'] == 'plus'){
						$username = $_SESSION['username'];
						$password = $_SESSION['password'];
						$itemid = $_POST['identitas'];
						$banyakitem = 1;
						$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$username,$password);
						$exquery->execute();
						$tanggal = date("Y-m-d H:i:s");
						$tanggaldate = $_SESSION['tglafter'];
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
						}
						$query2 = "SELECT id,itemid,COUNT(*) FROM `keluar` WHERE itemid = $itemid AND usermanagerid = $iduser AND tanggal = '$tanggaldate'";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$itemid = $hasil2["itemid"];

								$query = "UPDATE `keluar` SET jumlah = jumlah + ?,tanggal = ? WHERE id = ? ";
								$exquery=$Koneksi->getKonek()->prepare($query);
								$exquery->bind_param("isi",$banyakitem,$tanggaldate,$idcart);
								$result = $exquery->execute();
								if($result){

									$j = $banyakitem;
									$n = $itemid;

									$query = "UPDATE produk SET stock = stock-? WHERE id = ? ";
									$exquery21=$Koneksi->getKonek()->prepare($query);
									$exquery21->bind_param("ii",$j,$n);
									$exquery = $exquery21->execute();

									$query = "SELECT * FROM produk WHERE id = ? ";
									$exquery21=$Koneksi->getKonek()->prepare($query);
									$exquery21->bind_param("i",$n);
									$exquery21->execute();

									$tampil21=$exquery21->get_result()->fetch_all(MYSQLI_ASSOC);

									$namaproduk = $tampil21[0]["nama"];
									$stocknow = $tampil21[0]["stock"];

									if($stocknow < 10){

										echo "<script>

										jQuery.ajax({
											url:'../send.php',
											data:'stock=$stocknow&nama=$namaproduk',
											type:'post',
											success:function(result){

											}
										});

										</script>";
									}

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
						echo "<script>window.location='?page=$namapage&i=delete3&id=".$_POST['identitas']."'</script>";
					}
				}
				else{
					$_SESSION['tglafter'] = date("Y-m-d");
				}


				$username = $_SESSION['username'];
				$password = $_SESSION['password'];
				$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
				$exquery=$Koneksi->getKonek()->prepare($query);
				$exquery->bind_param("ss",$username,$password);
				$exquery->execute();
				$tanggal = date("Y-m-d H:i:s");
				$tanggaldate = date("Y-m-d");
				if($exquery){
					$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

					$iduser = $tampil[0]["Id"];
				}

				if(@$_POST['tglafter'] != ""){
					$tglakhir = date("Y-m-d", strtotime($_POST['tglafter']));
					$_SESSION['tglafter'] = $tglakhir;
				}
				else{
					if(!isset($_SESSION['tglafter'])){
						$tglakhir = date("Y-m-d");
						$_SESSION['tglafter'] = $tglakhir;	
					}
				}
				$tglakhir =  $_SESSION['tglafter'];
								
				$query = "SELECT * FROM `keluar` WHERE usermanagerid = $iduser AND tanggal = '$tglakhir'";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<input type=hidden id=banyakitem name=banyakitem>";
					echo "<h1 class='title'>Data - Data Retur/Kirim</h1>";
					echo "<div style='margin:auto;width:50%;margin-top:15px;margin-bottom:10px;'>
							<input style='width:80%;border:1px solid blue;border-radius:25px;' type='text' class='tanggal' name='tglafter' id='tglafter' onchange='cekTanggal()' autocomplete='off'><br>
							$tglakhir
						</div>";
					echo "<ul>";
					echo "<li  style=\"width:40%;background-color:#443AD8;border-radius:30px;\" class=\"geser\"><a href=\"?page=penjualan&i=input3\">+ Retur/Kirim</a></li>";
					echo "</ul>";
					echo "<div style='overflow-x: scroll;'>";
					echo "<table align=center border=1 id=tabelku class=CSSTableGenerator >
					<tr>
					</tr>";
					echo "</table>";
					echo "</div>";
					echo "</form>";
				}
				else{
					echo "Anda tidak berhasil menampilkan data<br>";
				}
				mysqli_close($Koneksi->getKonek());
				
				
			?>
			<script>
				$('#pencarian').on('keyup keypress', function(e) {
				  var keyCode = e.keyCode || e.which;
				  if (keyCode === 13) { 
				    e.preventDefault();
				    search();
				    return false;
				  }
				});
				$('#minharga').on('keyup keypress', function(e) {
				  var keyCode = e.keyCode || e.which;
				  if (keyCode === 13) { 
				    e.preventDefault();
				    search();
				    return false;
				  }
				});
				$('#maxharga').on('keyup keypress', function(e) {
				  var keyCode = e.keyCode || e.which;
				  if (keyCode === 13) { 
				    e.preventDefault();
				    search();
				    return false;
				  }
				});

				var key = "";
				var minharga = "";
				var maxharga = "";
				function search(){
					load_flag=0;
					key=document.getElementById('pencarian').value;
					jQuery('#tabelku').html('<tr></tr>');
					loadMore(load_flag,key);
				}
				var load_flag=0;
				var lagiloading=false;
				loadMore(load_flag,key);
				function loadMore(start,key){
					if(lagiloading==false){
						lagiloading=true;
					jQuery.ajax({
						url:'kasir/page/<?php echo $namapage;?>/get6.php',
						data:'start='+load_flag+'&key='+key,
						type:'post',
						success:function(result){
							jQuery('#tabelku').append(result);
							load_flag+=3;
							lagiloading=false;
						}
					});
					}
				}
				jQuery(document).ready(function(){
					jQuery(window).scroll(function(){
						if(jQuery(window).scrollTop()>=jQuery(document).height() - jQuery(window).height() - 100){
							loadMore(load_flag,key);
						} 
					})
				});
			</script>