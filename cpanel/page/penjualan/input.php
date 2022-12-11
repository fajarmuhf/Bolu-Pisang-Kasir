			<?php
				
				include "page/secure.php";
				
				$Koneksi->Konek("fandystore");

				$namapage = "penjualan";
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != "" && @$_POST['banyakitem'] != ""){
					if($_POST['Aksi'] == 'tambah'){
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
									echo "Anda telah berhasil menginput data ke keranjang<br>";
								}
								else{
									echo "Anda tidak berhasil menginput data ke keranjang<br>";
								}
							}
							else{

								$query = "INSERT INTO `cart` SELECT (COUNT(*)+1),0,?,?,?,?,0,'belumbayar',NULL,?,? FROM `cart` WHERE 1 ";
								$exquery=$Koneksi->getKonek()->prepare($query);
								$exquery->bind_param("iisiss",$iduser,$itemid,$username,$banyakitem,$tanggal,$tanggal);
								$result = $exquery->execute();
								if($result){
									echo "Anda telah berhasil menginput data ke keranjang<br>";
								}
								else{
									echo "Anda tidak berhasil menginput data ke keranjang<br>";
								}		
							}
						}
					}
				}				
								
				$query = "SELECT * FROM `produk` WHERE 1 ";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<input type=hidden id=banyakitem name=banyakitem>";
					echo "<h3>Data - Data ",ucfirst($namapage)."</h3>";
					echo "<input type=text placeholder='cari nama ,deskripsi atau tag barang...' name='pencarian' class='pencarian' id='pencarian'>";
					echo "<table align=center border=1 id=tabelku class=CSSTableGenerator >
					<tr>
						<td>Id</td><td>Nama</td><td>Deskripsi</td><td>Stok</td><td>Satuan</td><td>Harga</td><td>Perum</td></td><td>Tag</td><td>Gambar</td><td>Expire</td>
					<td>Aksi</td>
					</tr>";
					echo "</table>";
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
					jQuery('#tabelku').html('<tr><td>Id</td><td>Nama</td><td>Deskripsi</td><td>Stok</td><td>Satuan</td><td>Harga</td><td>Perum</td></td><td>Tag</td><td>Gambar</td><td>Expire</td><td>Aksi</td></tr>');
					loadMore(load_flag,key,minharga,maxharga);
				}
				var load_flag=0;
				var lagiloading=false;
				loadMore(load_flag,key,minharga,maxharga);
				function loadMore(start,key,minharga,maxharga){
					if(lagiloading==false){
						lagiloading=true;
					jQuery.ajax({
						url:'page/<?php echo $namapage;?>/get.php',
						data:'start='+load_flag+'&key='+key+'&minharga='+minharga+'&maxharga='+maxharga,
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
						if(jQuery(window).scrollTop()>=jQuery(document).height() - jQuery(window).height() - 20){
							loadMore(load_flag,key,minharga,maxharga);
						} 
					})
				});
			</script>