			<?php
				include "page/secure.php";
				
				$namapage = "perumahan";
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'edit'){
						echo "<script>window.location='?page=$namapage&i=edit&id=".$_POST['identitas']."'</script>";
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
					echo "<h1 class='title'>Data - Data ",ucfirst($namapage)."</h1>";
					echo "<input type=text placeholder='cari nama atau lokasi $namapage...' name='pencarian' class='pencarian' id='pencarian'>";
					echo "<table align=center border=1 id=tabelku class=CSSTableGenerator >
						<tr><td>Id</td><td>Nama</td><td>Lokasi</td><td>Aksi</td></tr>
					";
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
				$('#pencarian').on('keyup keypress', function(e) {
				  var keyCode = e.keyCode || e.which;
				  if (keyCode === 13) { 
				    e.preventDefault();
				    search();
				    return false;
				  }
				});

				var key = "";
				function search(){
					load_flag=0;
					key=document.getElementById('pencarian').value;
					jQuery('#tabelku').html('<tr><td>Id</td><td>Nama</td><td>Lokasi</td><td>Aksi</td></tr>');
					loadMore(load_flag,key);
				}
				
				var load_flag=0;
				var lagiloading=false;
				loadMore(load_flag,key);
				function loadMore(start,key){
					if(lagiloading==false){
						lagiloading=true;
					jQuery.ajax({
						url:'page/<?php echo $namapage;?>/get.php',
						data:'start='+load_flag+'&key='+key,
						type:'post',
						success:function(result){
							jQuery('#tabelku').append(result);
							load_flag+=10;
							lagiloading=false;
						}
					});
					}
				}
				jQuery(document).ready(function(){
					jQuery(window).scroll(function(){
						if(jQuery(window).scrollTop()>=jQuery(document).height() - jQuery(window).height()-100){
							loadMore(load_flag,key);
						} 
					})
				});
			</script>