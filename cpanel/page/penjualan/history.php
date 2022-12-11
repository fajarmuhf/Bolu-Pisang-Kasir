			<script>
				  $(function() {
					$( ".tanggal" ).datetimepicker();
				  });
				  function cekTanggal(){
					  if(document.getElementById('tglbefore').value != '' && document.getElementById('tglafter').value != ''){
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
					else if($_POST['Aksi'] == 'hapus2'){
						echo "<script>window.location='?page=$namapage&i=delete2&id=".$_POST['identitas']."'</script>";
					}
					else if($_POST['Aksi'] == 'restock'){
						echo "<script>window.location='?page=$namapage&i=restock&id=".$_POST['identitas']."'</script>";
					}
					else if($_POST['Aksi'] == 'terimauang'){
						echo "<script>window.location='?page=$namapage&i=terimauang&id=".$_POST['identitas']."'</script>";
					}
				}


				if(@$_POST['checkstatus'] == "yes"){
					$username = $_SESSION['username'];
					$password = $_SESSION['password'];
					$biayaongkir = 2000;
					$pembayaran = 'Cash';
					$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
					$exquery=$Koneksi->getKonek()->prepare($query);
					$exquery->bind_param("ss",$username,$password);
					$exquery->execute();
					$tanggal = date("Y-m-d H:i:s");
					if($exquery){
						$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

						$iduser = $tampil[0]["Id"];
					}
					$query2 = "SELECT A.id FROM `cart` as A,produk as B WHERE A.itemid = B.id AND usermanagerid = $iduser AND status = 'belumbayar'";
					$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
					$num = 0;
					if($exquery2){
						while($hasil2 = mysqli_fetch_array($exquery2)){
							$idcart = $hasil2[0];
							$statusorder = 'ordered';
							$query = "UPDATE `cart` SET status = ? WHERE id = ? ";
							$exquery=$Koneksi->getKonek()->prepare($query);
							$exquery->bind_param("si",$statusorder,$idcart);
							$result = $exquery->execute();

							$num++;
							
						}
					}
					if($num > 0){
						$query = "INSERT INTO `clientorder` SELECT (COUNT(*)+1),?,NULL,?,NULL,?,?,'','','selesai',0,0,?,? FROM `clientorder` WHERE 1 ";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("isisss",$iduser,$username,$biayaongkir,$pembayaran,$tanggal,$tanggal);
						$result = $exquery->execute();
						if($result){
							echo "Anda telah berhasil menginput data ke keranjang<br>";
						}
						else{
							echo "Anda tidak berhasil menginput data ke keranjang<br>";
						}	
					}
				}				


				$username = $_SESSION['username'];
				$password = $_SESSION['password'];
				$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
				$exquery=$Koneksi->getKonek()->prepare($query);
				$exquery->bind_param("ss",$username,$password);
				$exquery->execute();
				date_default_timezone_set('Asia/Jakarta');
				$tanggal = date("Y-m-d H:i:s");
				if($exquery){
					$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

					$iduser = $tampil[0]["Id"];
				}

				if(@$_POST['tglbefore'] != "" && @$_POST['tglafter'] != ""){
					$tglawal = date("Y-m-d H:m", strtotime($_POST['tglbefore']));
					$tglawal = $tglawal.":00";
					
					$tglakhir = date("Y-m-d H:m", strtotime($_POST['tglafter']));
					$tglakhir = $tglakhir.":00";	
				}
				else{
					$tglawal = date("Y-m-1 00:00:00");
					$tglakhir = date("Y-m-d H:i:s");
				}

				$_SESSION['tglbefore'] = $tglawal;
				$_SESSION['tglafter'] = $tglakhir;
								
				$query = "SELECT * FROM `cart` WHERE usermanagerid = $iduser AND status='belumbayar' ";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<input type=hidden id=checkstatus name=checkstatus>";
					echo "
						<div style='float:left;width:33%;margin-top:15px;'>
							<input style='border:1px solid blue;border-radius:25px;' type='text' class='tanggal' name='tglbefore' id='tglbefore' onchange='cekTanggal()'><br>
							$tglawal
						</div>
						<div style='float:left;width:33%;'>
							<h3>Data - Data ",ucfirst($namapage)."</h3>
						</div>
						<div style='float:left;width:33%;margin-top:15px;'>
							<input style='border:1px solid blue;border-radius:25px;' type='text' class='tanggal' name='tglafter' id='tglafter' onchange='cekTanggal()'><br>
							$tglakhir
						</div>";
					echo "<div style='clear:both;'><div id='tabels'>";
					
					
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
					jQuery('#tabels').html('');
					loadMore(load_flag,key);
				}
				var load_flag=0;
				var lagiloading=false;
				loadMore(load_flag,key);
				function loadMore(start,key){
					if(lagiloading==false){
						lagiloading=true;
					jQuery.ajax({
						url:'page/<?php echo $namapage;?>/get3.php',
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