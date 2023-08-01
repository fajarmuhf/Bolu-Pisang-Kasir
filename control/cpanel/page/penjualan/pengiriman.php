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
						$query2 = "SELECT id,itemid,jumlah,COUNT(*) FROM `pengiriman` WHERE itemid = $itemid AND usermanagerid = $iduser AND tanggal = '$tanggaldate'";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$jumlahcart = $hasil2["jumlah"];
								$itemid = $hasil2["itemid"];
								if($banyakitem > 0){
									$query = "UPDATE `pengiriman` SET jumlah = ?,tanggal = ? WHERE id = ? ";
									$exquery=$Koneksi->getKonek()->prepare($query);
									$exquery->bind_param("isi",$banyakitem,$tanggaldate,$idcart);
									$result = $exquery->execute();
									if($result){

										$j = $jumlahcart-$banyakitem;
										$n = $itemid;

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
						$query2 = "SELECT id,jumlah,itemid,COUNT(*) FROM `pengiriman` WHERE itemid = $itemid AND usermanagerid = $iduser AND tanggal = '$tanggaldate'";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$jumlahcart = $hasil2["jumlah"];
								$itemid = $hasil2["itemid"];
								if($jumlahcart == 1){
									$nilai = $idcart;
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
														$j = $banyakitem;
														$n = $itemid;

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
														   //window.location = 'kasir.php?page=penjualan&i=pengiriman';
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

													$j = $banyakitem;
													$n = $itemid;

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
													   //window.location = 'kasir.php?page=penjualan&i=pengiriman';
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
									$query = "UPDATE `pengiriman` SET jumlah = jumlah - ?,tanggal = ? WHERE id = ? ";
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
						$query2 = "SELECT id,itemid,COUNT(*) FROM `pengiriman` WHERE itemid = $itemid AND usermanagerid = $iduser AND tanggal = '$tanggaldate'";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$itemid = $hasil2["itemid"];

								$query = "UPDATE `pengiriman` SET jumlah = jumlah + ?,tanggal = ? WHERE id = ? ";
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
					$_SESSION['perum'] = 'Jalan Raya Bogor';
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

				if(@$_POST['perum'] != ""){
					$namaperumahan = $_POST['perum'];
					$_SESSION['perum'] = $namaperumahan;
				}
				else{
					if(!isset($_SESSION['tglafter'])){
						$namaperumahan = 'Jalan Raya Bogor';
						$_SESSION['perum'] = $namaperumahan;	
					}
				}
				$namaperumahan =  $_SESSION['perum'];

								
				$query = "SELECT * FROM `pengiriman` WHERE usermanagerid = $iduser AND tanggal = '$tglakhir'";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<input type=hidden id=banyakitem name=banyakitem>";
					echo "<h1 class='title'>Data - Data Harian</h1>";
					echo "<div style='margin:auto;width:50%;margin-top:15px;margin-bottom:10px;'>
							<input style='width:80%;border:1px solid blue;border-radius:25px;' type='text' class='tanggal' name='tglafter' id='tglafter' onchange='cekTanggal()' autocomplete='off'><br>
							$tglakhir
						</div>";
					echo "<select name='perum' id='perum' style='margin:auto;width:50%;margin-bottom:15px;border-radius:25px;' onchange='document.getElementById(\"tglafter\").value=\"$tglakhir\";document.getElementById(\"daftar\").submit();'>";
					
					$username = $_SESSION['username'];
					$password = $_SESSION['password'];

					$query='SELECT Id,Perum FROM `user-manager` WHERE Username = ? AND Password = ?';

					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param('ss',$username,$password);
					$exquery->execute();
					
					if($exquery){
						$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

						$iduser = $tampil[0]['Id'];
					}
					$perumold = $_SESSION['perum'];

					$kueh = 'SELECT * FROM `perumahan` WHERE 1 ';
					$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
					if($exkueh){
						while($hasilkueh = mysqli_fetch_array($exkueh)){
							$perumahan = $hasilkueh['nama'];
							if(strcmp($perumold, $perumahan) == 0){
								echo '<option value="'.$perumahan.'" selected>'.$perumahan.'</option>';
							}
							else{
								echo '<option value="'.$perumahan.'">'.$perumahan.'</option>';
							}
						}
					}

					echo "</select>";
					echo "<div id='tabels'>";
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
						url:'page/<?php echo $namapage;?>/get4.php',
						data:'start='+load_flag+'&key='+key,
						type:'post',
						success:function(result){
							jQuery('#tabels').append(result);
							load_flag+=3;
							lagiloading=false;
						}
					});
					}
				}
			</script>