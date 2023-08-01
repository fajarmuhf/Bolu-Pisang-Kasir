			<?php
				include "page/secure.php";
				
				$namapage = "aset";
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
								
				$query = "SELECT * FROM `aset` WHERE 1 ";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<h1 class='title'>Data - Data ",ucfirst($namapage)."</h1>";
					echo "<input type=text placeholder='cari nama aset ...' name='pencarian' class='pencarian' id='pencarian'>";
					echo "<table align=center border=1 id=tabelku class=CSSTableGenerator >
					<tr>
						<td>Id</td><td>Nama</td><td>Gambar</td><td>Harga Perolehan</td><td>Umur</td><td>Harga Sisa</td><td>Tanggal Beli</td><td>Biaya Penyusutan</td><td>Harga Jual</td><td>Penyusutan / Hari</td>
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
			<div id="tes" class="title"></div>
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
					jQuery('#tabelku').html('<tr><td>Id</td><td>Nama</td><td>Gambar</td><td>Harga Perolehan</td><td>Umur</td><td>Harga Sisa</td><td>Tanggal Beli</td><td>Biaya Penyusutan</td><td>Harga Jual</td><td>Penyusutan / Hari</td><td>Aksi</td></tr>');
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
						if ($(window).scrollTop() + $(window).height() >= $(document).height()-100) {
    						loadMore(load_flag,key,minharga,maxharga);
						} 
					})
				});
			</script>