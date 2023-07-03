			<?php
				include "page/secure.php";
				
				$Koneksi->Konek("fandystore");
				$namapage = "penjualan";
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'edit'){
						echo "<script>window.location='?page=$namapage&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else{
						echo "<script>window.location='?page=$namapage&i=delete&id=".$_POST['identitas']."'</script>";
					}
				}
				if(@$_POST['checkstatus'] == "yes"){
					$id = $_SESSION['id'];

					$pembayaran = 'Cash';
					$query="SELECT id,perum,blok,nama FROM `user` WHERE idfacebook = ?";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("s",$id);
					$exquery->execute();
					date_default_timezone_set("Asia/Jakarta");
					$tanggal = date("Y-m-d H:i:s");
					if($exquery){
						$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

						$iduser = $tampil[0]["id"];
						$username = $tampil[0]["nama"];
						$perum = $tampil[0]["perum"];
						$blok = $tampil[0]["blok"];
					}
	  				$sqlbiaya="SELECT * FROM feekurir WHERE perum = '$perum'";
					$exquery2 = mysqli_query($Koneksi->getKonek(),$sqlbiaya);
					$hasil2 = mysqli_fetch_array($exquery2);
					$biayaongkir = 0;
					//$biayaongkir = $hasil2["biaya"];
					$query2 = "SELECT A.id FROM `cart` as A,produk as B WHERE A.itemid = B.id AND userid = $iduser AND status = 'belumbayar'";
					$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
					$num = 0;
					if($exquery2){
						while($hasil2 = mysqli_fetch_array($exquery2)){
							$idcart = $hasil2[0];
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
						$driverid = NULL;
						$driverusername = NULL;
						$statusdriver = 'Pencarian Driver';

						$sqldriver="SELECT * FROM driver WHERE pencarian = '1' AND perum = '$perum' AND banned < NOW() ORDER BY RAND()";
						$kuehs = mysqli_query($Koneksi->getKonek(),$sqldriver);
						if($kuehs){
							$rowdriver = mysqli_fetch_array($kuehs);

							$driverid = $rowdriver["id"];
							$drivertoken = $rowdriver["fcmtoken"];
							$driverusername = $rowdriver["username"];
							$maxpesanandriver = $rowdriver["maxpesanan"];
							$statusdriver = 'Mengambil Pesanan';

						}
						$alamat = $perum." ".$blok;
						$query = "INSERT INTO `clientorder` SELECT (COUNT(*)+1),?,?,?,?,?,?,'',?,?,0,0,NULL,NULL,?,? FROM `clientorder` WHERE 1 ";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("iississsss",$iduser,$driverid ,$username,$driverusername ,$biayaongkir,$pembayaran,$alamat,$statusdriver,$tanggal,$tanggal);
						$result = $exquery->execute();
						if($result){
							$kueh = "SELECT * FROM clientorder as A,cart as B WHERE A.restock IS NULL AND A.id = ? AND A.id = B.orderid";
							$exquery2=$Koneksi->getKonek()->prepare($kueh);
							$exquery2->bind_param("i",$ordernum);
							$exkueh2 = $exquery2->execute();
							if($exkueh2){
								$hasil = $exquery2->get_result()->fetch_all(MYSQLI_ASSOC);
								for($i=0;$i<count($hasil);$i++){
									$n = $hasil[$i]["itemid"];
									$j = $hasil[$i]["jumlah"];
							
									$query = "UPDATE produk SET stock = stock-? WHERE id = ? ";
									$exquery21=$Koneksi->getKonek()->prepare($query);
									$exquery21->bind_param("ii",$j,$n);
									$exquery = $exquery21->execute();
									
								}
								if(count($hasil) > 0){
									echo "Anda telah berhasil menginput data ke keranjang<br>";	
								}
								else{
									echo "Anda tidak berhasil menginput data ke keranjang<br>";
								}
							}
							else{
								echo "Anda tidak berhasil menginput data ke keranjang<br>";
							}
						}
						else{
							echo "Anda tidak berhasil menginput data ke keranjang<br>";
						}	
					}
				}				


				$id = $_SESSION['id'];
				$query="SELECT id FROM `user` WHERE idfacebook = ?";
				$exquery=$Koneksi->getKonek()->prepare($query);
				$exquery->bind_param("s",$id);
				$exquery->execute();
				$tanggal = date("Y-m-d H:i:s");
				if($exquery){
					$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

					$iduser = $tampil[0]["id"];
				}
								
				$query = "SELECT * FROM `cart` WHERE usermanagerid = $iduser AND status='belumbayar' ";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<input type=hidden id=checkstatus name=checkstatus>";
					echo "<h1 class='title'>Data - Data keranjang</h1>";
					echo "<div style='overflow-x: scroll;'>";
					echo "<table align=center border=1 id=tabelku class=CSSTableGenerator >
					<tr>
						<td>Nama</td><td>Gambar</td><td>Jumlah</td><td>Harga</td><td>Total Bayar</td>
					<td>Aksi</td>
					</tr>";
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
					jQuery('#tabelku').html('<tr><td>Id</td><td>Nama</td><td>Deskripsi</td><td>Stok</td><td>Satuan</td><td>Harga</td><td>Perum</td></td><td>Tag</td><td>Gambar</td><td>Expire</td><td>Aksi</td></tr>');
					loadMore(load_flag,key);
				}
				var load_flag=0;
				var lagiloading=false;
				loadMore(load_flag,key);
				function loadMore(start,key){
					if(lagiloading==false){
						lagiloading=true;
					jQuery.ajax({
						url:'page/<?php echo $namapage;?>/get2.php',
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