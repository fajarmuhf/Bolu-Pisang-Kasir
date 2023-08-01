			<?php
				
				include "page/secure.php";
				
				$Koneksi->Konek("fandystore");

				function bool_to_str($val)
				{
				    if ($val === true) {
				        return 'true';
				    }
				 
				    if ($val === false) {
				        return 'false';
				    }
				 
				    return $val;
				}

				$namapage = "penjualan";
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != "" && @$_POST['banyakitem'] != ""){
					if($_POST['Aksi'] == 'tambah'){
						$username = $_SESSION['username'];
						$password = $_SESSION['password'];
						$itemid = $_POST['identitas'];
						$banyakitem = $_POST['banyakitem'];
						$query="SELECT Id,Perum FROM `user-manager` WHERE Username = ? AND Password = ?";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$username,$password);
						$exquery->execute();
						$tanggal = $_SESSION['tglafter'];
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
							$perum = $tampil[0]["Perum"];
						}
						$query2 = "SELECT id,COUNT(*) FROM `pengiriman` WHERE itemid = $itemid AND usermanagerid = $iduser AND tanggal = '$tanggal' ";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$query = "UPDATE `pengiriman` SET jumlah = jumlah + ? WHERE id = ? ";
								$exquery=$Koneksi->getKonek()->prepare($query);
								$exquery->bind_param("ii",$banyakitem,$idcart);
								$result = $exquery->execute();
								if($result){
									$n = $itemid;
									$j = $banyakitem;
							
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
								$query = "INSERT INTO `pengiriman` SELECT (COUNT(*)+1),?,?,?,?,? FROM `pengiriman` WHERE 1 ";
								$exquery=$Koneksi->getKonek()->prepare($query);
								$exquery->bind_param("iiiss",$iduser,$itemid,$banyakitem,$perum,$tanggal);
								$result = $exquery->execute();
								if($result){
									$n = $itemid;
									$j = $banyakitem;
							
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
					else if($_POST['Aksi'] == 'addqr'){
						$username = $_SESSION['username'];
						$password = $_SESSION['password'];
						$barcodeid = $_POST['identitas'];
						$banyakitem = $_POST['banyakitem'];
						$query="SELECT Id,Perum FROM `user-manager` WHERE Username = ? AND Password = ?";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$username,$password);
						$exquery->execute();
						$tanggal = $_SESSION['tglafter'];
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
							$perum = $tampil[0]["Perum"];
						}
						
						$query="SELECT id FROM `produk` WHERE barcode = ? AND perum = ?";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$barcodeid,$perum);
						$exquery->execute();
						
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$itemid = $tampil[0]["id"];
						}

						$query2 = "SELECT id,COUNT(*) FROM `pengiriman` WHERE itemid = $itemid AND usermanagerid = $iduser AND tanggal = '$tanggal' ";
						$exquery2 = mysqli_query($Koneksi->getKonek(),$query2);
						if($exquery2){
							$hasil2 = mysqli_fetch_array($exquery2);
							if($hasil2["COUNT(*)"] > 0){
								$idcart = $hasil2["id"];
								$query = "UPDATE `pengiriman` SET jumlah = jumlah + ? WHERE id = ? ";
								$exquery=$Koneksi->getKonek()->prepare($query);
								$exquery->bind_param("ii",$banyakitem,$idcart);
								$result = $exquery->execute();
								if($result){
									$n = $itemid;
									$j = $banyakitem;
							
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
								$query = "INSERT INTO `pengiriman` SELECT (COUNT(*)+1),?,?,?,?,? FROM `pengiriman` WHERE 1 ";
								$exquery=$Koneksi->getKonek()->prepare($query);
								$exquery->bind_param("iiiss",$iduser,$itemid,$banyakitem,$perum,$tanggal);
								$result = $exquery->execute();
								if($result){
									$n = $itemid;
									$j = $banyakitem;
							
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
				else{	
					$qrshowstatus = 'false';
					$_SESSION['qrshowstatus'] = $qrshowstatus;	
				}				

				if(@$_POST['scanval'] != ""){
					$qrshowstatus = bool_to_str($_POST['scanval']);
					$_SESSION['qrshowstatus'] = $qrshowstatus;
				}
				else{
					if(!isset($_SESSION['qrshowstatus'])){
						$qrshowstatus = 'false';
						$_SESSION['qrshowstatus'] = $qrshowstatus;	
					}
				}
				$qrshowstatus =  bool_to_str($_SESSION['qrshowstatus']);
								
				$query = "SELECT * FROM `produk` WHERE 1 ";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=AksiL name=AksiL>";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<input type=hidden id=banyakitem name=banyakitem>";
					echo "<input type=hidden id=scanval name=scanval>";
					echo "<h1 class='title'>Terima Barang</h1>";
					echo "<input type=text placeholder='cari nama ,deskripsi atau tag barang...' name='pencarian' class='pencarian' id='pencarian'>";
					echo "<script>

						var qrshowstatus = $qrshowstatus;
						function ShowQR(){

							qrshowstatus = !qrshowstatus;
							if(qrshowstatus){
								document.getElementById('qrpress').innerHTML = 'Hide Scan';
								document.getElementById('scanval').value = qrshowstatus;
								document.getElementById('qr-reader').style.visibility = 'visible';
								document.getElementById('qr-reader').style.height = '100%';
								$('#html5-qrcode-button-camera-stop').trigger('click');
								html5QrcodeScanner.render(onScanSuccess);
							}
							else{
								document.getElementById('qrpress').innerHTML = 'Show Scan';
								document.getElementById('scanval').value = qrshowstatus;
								document.getElementById('qr-reader').style.visibility = 'hidden';	
								document.getElementById('qr-reader').style.height = '0px';
								$('#html5-qrcode-button-camera-stop').trigger('click');
							}
						}	

					</script>";
					echo "<ul>";
					echo "<li style=\"width:40%;background-color:#443AD8;border-radius:30px;\" class=\"geser\" ><a onclick=\"ShowQR();\" id=\"qrpress\">".($qrshowstatus == "true" ? "Hide Scan" : "Show Scan")."</a></li>";
					echo "</ul>";
					echo "<div id='qr-reader' style='visibility:".($qrshowstatus == "true" ? "visible" : "hidden").";width: 100%;height:0px;'></div>";
					echo "<script>					
						var html5QrcodeScanner = new Html5QrcodeScanner(
							'qr-reader', { fps: 10, qrbox: 250 ,rememberLastUsedCamera: true});

						function onScanSuccess(decodedText, decodedResult) {
						    document.getElementById(\"AksiL\").value=\"addqr\";
						    document.getElementById(\"AksiL\").name=\"Aksi\";
						    document.getElementById(\"identitas\").value=decodedText;
						    document.getElementById(\"banyakitem\").value=1;
						    document.getElementById(\"daftar\").submit();
						}
						".($qrshowstatus == "true" ? "
								document.getElementById('qrpress').innerHTML = 'Hide Scan';
								document.getElementById('scanval').value = qrshowstatus;
								document.getElementById('qr-reader').style.visibility = 'visible';
								document.getElementById('qr-reader').style.height = '100%';
								$('#html5-qrcode-button-camera-stop').trigger('click');
								html5QrcodeScanner.render(onScanSuccess);" : "")."
					</script>";
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
				var myTimeout = setTimeout(function(){
					
				 },2000);
				$('#pencarian').on('keyup', function() {
					 //if (this.value.length > 1) {
						 clearTimeout(myTimeout);
						 myTimeout = setTimeout(function(){
							search();
						 },500);
						  // do search for this.value here
					 //}
				});
				$('#pencarian').on('keyup keypress', function(e) {
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
					loadMore(load_flag,key,minharga,maxharga);
				}
				var load_flag=0;
				var lagiloading=false;
				loadMore(load_flag,key,minharga,maxharga);
				function loadMore(start,key,minharga,maxharga){
					if(lagiloading==false){
						lagiloading=true;
					jQuery.ajax({
						url:'kasir/page/<?php echo $namapage;?>/get5.php',
						data:'start='+load_flag+'&key='+key+'&minharga='+minharga+'&maxharga='+maxharga,
						type:'post',
						success:function(result){
							jQuery('#tabelku').append(result);
							load_flag+=5;
							lagiloading=false;
						}
					});
					}
				}
				jQuery(document).ready(function(){
					jQuery(window).scroll(function(){
						if(jQuery(window).scrollTop()>=jQuery(document).height() - jQuery(window).height() - 100){
							loadMore(load_flag,key,minharga,maxharga);
						} 
					})
				});
			</script>