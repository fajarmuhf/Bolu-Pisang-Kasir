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
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
						}
						$query2 = "SELECT id,jumlah,COUNT(*) FROM `cart` WHERE itemid = $itemid AND usermanagerid = $iduser AND status = 'belumbayar'";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$jumlahcart = $hasil2["jumlah"];
								if($banyakitem > 0){
									$query = "UPDATE `cart` SET jumlah = ?,tanggal = ?,tanggalupdate = ? WHERE id = ? ";
									$exquery=$Koneksi->getKonek()->prepare($query);
									$exquery->bind_param("issi",$banyakitem,$tanggal,$tanggal,$idcart);
									$result = $exquery->execute();
									if($result){
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
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
						}
						$query2 = "SELECT id,jumlah,COUNT(*) FROM `cart` WHERE itemid = $itemid AND usermanagerid = $iduser AND status = 'belumbayar'";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$jumlahcart = $hasil2["jumlah"];
								if($jumlahcart == 1){
									$nilai = $idcart;
									$query = "DELETE FROM `cart` WHERE id = ? ";
									$exquery21=$Koneksi->getKonek()->prepare($query);
									$exquery21->bind_param("i",$nilai);
									$exquery = $exquery21->execute();
									if($exquery){
										$query2 = "SELECT COUNT(*) FROM cart WHERE Id > ?";
										$exquery31=$Koneksi->getKonek()->prepare($query2);
										$exquery31->bind_param("i",$nilai);
										$exquery2 = $exquery31->execute();
										if($exquery2){
											$hitung = $exquery31->get_result()->fetch_all(MYSQLI_ASSOC);
											if($hitung[0]['COUNT(*)'] > 0){
												$query3 = "UPDATE cart SET Id = (Id-1) WHERE Id > ?";
												$exquery32=$Koneksi->getKonek()->prepare($query3);
												$exquery32->bind_param("i",$nilai);
												$exquery3 = $exquery32->execute();
												if($exquery3){
													$totalid = $hitung[0]["COUNT(*)"]+1;
													$reset = "ALTER TABLE cart AUTO_INCREMENT = $totalid";
													$exquery4 = $Koneksi->getKonek()->query($reset);
													if($exquery4){
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
														   //window.location = 'kasir.php?page=penjualan';
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
												$reset = "ALTER TABLE cart AUTO_INCREMENT = $totalid";
												$exquery4 = $Koneksi->getKonek()->query($reset);
												if($exquery4){
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
													   //window.location = 'kasir.php?page=penjualan';
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
									$query = "UPDATE `cart` SET jumlah = jumlah - ?,tanggal = ?,tanggalupdate = ? WHERE id = ? ";
									$exquery=$Koneksi->getKonek()->prepare($query);
									$exquery->bind_param("issi",$banyakitem,$tanggal,$tanggal,$idcart);
									$result = $exquery->execute();
									if($result){
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
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
						}
						$query2 = "SELECT id,COUNT(*) FROM `cart` WHERE itemid = $itemid AND usermanagerid = $iduser AND status = 'belumbayar'";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$query = "UPDATE `cart` SET jumlah = jumlah + ?,tanggal = ?,tanggalupdate = ? WHERE id = ? ";
								$exquery=$Koneksi->getKonek()->prepare($query);
								$exquery->bind_param("issi",$banyakitem,$tanggal,$tanggal,$idcart);
								$result = $exquery->execute();
								if($result){
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
						echo "<script>window.location='?page=$namapage&i=delete&id=".$_POST['identitas']."'</script>";
					}
				}
				if(@$_POST['checkstatus'] == "yes"){
					$username = $_SESSION['username'];
					$password = $_SESSION['password'];

					$pembayaran = 'Cash';
					$query="SELECT Id,Perum FROM `user-manager` WHERE Username = ? AND Password = ?";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("ss",$username,$password);
					$exquery->execute();
					date_default_timezone_set("Asia/Jakarta");
					$tanggal = date("Y-m-d H:i:s");
					if($exquery){
						$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

						$iduser = $tampil[0]["Id"];
						$perum = $tampil[0]["Perum"];
					}
	  				$sqlbiaya="SELECT * FROM feekurir WHERE perum = '$perum'";
					$exquery2 = mysqli_query($Koneksi->getKonek(),$sqlbiaya);
					$hasil2 = mysqli_fetch_array($exquery2);
					$biayaongkir = 0;
					//$biayaongkir = $hasil2["biaya"];
					$query2 = "SELECT A.id,B.stock,B.nama FROM `cart` as A,produk as B WHERE A.itemid = B.id AND usermanagerid = $iduser AND status = 'belumbayar'";
					$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
					$num = 0;
					$stockproduk = 0;
					$namaproduk = '';
					if($exquery2){
						while($hasil2 = mysqli_fetch_array($exquery2)){
							$idcart = $hasil2[0];
							$stockproduk = $hasil2[1];
							$namaproduk = $hasil2[2];
							$statusorder = 'ordered';
							$query21 = "SELECT COUNT(*) FROM `clientorder` WHERE 1";
							$exquery21 = mysqli_query($Koneksi->getKonek(),$query21);
							if($exquery21){
								$hasil21 = mysqli_fetch_array($exquery21);
								$ordernum = $hasil21["COUNT(*)"]+1; 
							}
							$query = "UPDATE `cart` SET status = ?,orderid = ? WHERE id = ? ";
							$exquery=$Koneksi->getKonek()->prepare($query);
							$exquery->bind_param("sii",$statusorder,$ordernum,$idcart);
							$result = $exquery->execute();

							$num++;
							
						}
					}
					if($num > 0){
						$query = "INSERT INTO `clientorder` SELECT (COUNT(*)+1),?,NULL,?,NULL,?,?,'','','selesai',0,0,NULL,'sudah',?,?,? FROM `clientorder` WHERE 1 ";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("isissss",$iduser,$username,$biayaongkir,$pembayaran,$tanggal,$tanggal,$perum);
						$result = $exquery->execute();
						if($result){
							$kueh = "SELECT * FROM clientorder as A,cart as B WHERE A.restock IS NULL AND A.status = 'selesai' AND A.id = ? AND A.id = B.orderid";
							$exquery2=$Koneksi->getKonek()->prepare($kueh);
							$exquery2->bind_param("i",$ordernum);
							$exkueh2 = $exquery2->execute();
							if($exkueh2){
								$hasil = $exquery2->get_result()->fetch_all(MYSQLI_ASSOC);
								for($i=0;$i<count($hasil);$i++){
									$n = $hasil[$i]["itemid"];
									$j = $hasil[$i]["jumlah"];

									$stocknow = $stockproduk-$j;

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
							
									$query = "UPDATE produk SET stock = stock-? WHERE id = ? ";
									$exquery21=$Koneksi->getKonek()->prepare($query);
									$exquery21->bind_param("ii",$j,$n);
									$exquery = $exquery21->execute();
									
								}
								if(count($hasil) > 0){
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


				$username = $_SESSION['username'];
				$password = $_SESSION['password'];
				$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
				$exquery=$Koneksi->getKonek()->prepare($query);
				$exquery->bind_param("ss",$username,$password);
				$exquery->execute();
				$tanggal = date("Y-m-d H:i:s");
				if($exquery){
					$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

					$iduser = $tampil[0]["Id"];
				}
								
				$query = "SELECT * FROM `cart` WHERE usermanagerid = $iduser AND status='belumbayar' ";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<input type=hidden id=banyakitem name=banyakitem>";
					echo "<input type=hidden id=checkstatus name=checkstatus>";
					echo "<h1 class='title'>Data - Data keranjang</h1>";
					echo "<ul>";
					echo "<li  style=\"width:40%;background-color:#443AD8;border-radius:30px;\" class=\"geser\"><a href=\"?page=penjualan&i=input\">+ Keranjang</a></li>";
					echo "</ul>";
					echo "<div style='overflow-x: scroll;'>";
					echo "<table align=center border=1 id=tabelku class=CSSTableGenerator ><tr></tr>
					";
					echo "</table>";
					echo "</div>";
					echo "<input class='button' style='margin-top:10px;margin-bottom:7px;' id='checkout' name='checkout' value='checkout' onclick=\"document.getElementById('checkstatus').value='yes';document.getElementById('daftar').submit()\">";
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
						url:'kasir/page/<?php echo $namapage;?>/get2.php',
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
			</script>