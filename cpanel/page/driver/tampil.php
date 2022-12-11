			<?php
				include "page/secure.php";

				$namapage = "driver";
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'edit'){
						echo "<script>window.location='?page=$namapage&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else{
						echo "<script>window.location='?page=$namapage&i=delete&id=".$_POST['identitas']."'</script>";
					}
				}				
				
				$Koneksi->Konek("fandystore");
								
				$query = "SELECT * FROM `driver` WHERE 1 ";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "<h3>Data - Data ",ucfirst($namapage)."</h3>";
					echo "<input type=text placeholder='cari nama $namapage...' name='pencarian' class='pencarian' id='pencarian'>";
					echo "<div id='tables'>
					";
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

				var key = "";
				function search(){
					load_flag=0;
					key=document.getElementById('pencarian').value;
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
							if(jQuery('#tables').html()=='\n\t\t\t\t\t'){
								jQuery('#tables').append(result);
							}
							else{
								jQuery('#tabelku').append(result);
							}
							load_flag+=3;
							lagiloading=false;
						}
					});
					}
				}
				jQuery(document).ready(function(){
					jQuery(window).scroll(function(){
						if(jQuery(window).scrollTop()>=jQuery(document).height() - jQuery(window).height()-20){
							loadMore(load_flag,key);
						} 
					})
				});
			</script>