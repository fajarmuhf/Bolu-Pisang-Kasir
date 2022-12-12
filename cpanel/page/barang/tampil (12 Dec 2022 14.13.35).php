			<?php
				include "page/secure.php";
				
				$namapage = "barang";
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'edit'){
						echo "<script>window.location='?page=$namapage&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else if($_POST['Aksi'] == 'salin'){
						echo "<script>window.location='?page=$namapage&i=salin&id=".$_POST['identitas']."'</script>";
					}
					else{
						echo "<script>window.location='?page=$namapage&i=delete&id=".$_POST['identitas']."'</script>";
					}
				}				
				
				$Koneksi->Konek("fandystore");
								
				$query = "SELECT * FROM `produk` WHERE 1 ";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
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
					minharga=document.getElementById('minharga').value;
					maxharga=document.getElementById('maxharga').value;
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