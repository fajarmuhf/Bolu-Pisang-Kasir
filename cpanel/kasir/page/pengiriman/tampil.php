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
				include "include/koneksi.php";
				
				if(@$_POST['Aksi'] != "" && @$_POST['identitas'] != ""){
					if($_POST['Aksi'] == 'edit'){
						echo "<script>window.location='?page=pengiriman&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else{
						echo "<script>window.location='?page=pengiriman&i=delete&id=".$_POST['identitas']."'</script>";
					}
				}
				
				if(@$_POST['tglbefore'] != "" && @$_POST['tglafter'] != ""){
					$tglawal = date("Y-m-d H:m", strtotime($_POST['tglbefore']));
					$tglawal = $tglawal.":00";
					
					$tglakhir = date("Y-m-d H:m", strtotime($_POST['tglafter']));
					$tglakhir = $tglakhir.":00";	
				}
				else{
					$tglawal = date("Y-m-d H:m:s",strtotime("-3 day"));
					$tglakhir = date("Y-m-d H:m:s",strtotime("+3 day"));
				}
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("bolu_pisang");
								
				$query2 = "SELECT Id FROM User WHERE Username = '".$_SESSION["username"]."' ";
				$exquery2 = mysql_query($query2);
				if($exquery2){
					$hasil = mysql_fetch_array($exquery2);			
					$query = "SELECT * FROM `Pengiriman` WHERE Id_User = '".$hasil[0]."' AND Tanggal >= '$tglawal' AND Tanggal <= '$tglakhir' ORDER BY Tanggal";
					$exquery = mysql_query($query);
					if($exquery){
						echo "<form action='' id=daftar method=POST >";
						echo "<input type=hidden id=identitas name=identitas>";
						echo "
						<div style='float:left;width:33%;margin-top:15px;'>
							<input style='border:1px solid blue;border-radius:25px;' type='text' class='tanggal' name='tglbefore' id='tglbefore' onchange='cekTanggal()'><br>
							$tglawal
						</div>
						<div style='float:left;width:33%;'>
							<h3>Data - Data Pengirirman</h3>
						</div>
						<div style='float:left;width:33%;margin-top:15px;'>
							<input style='border:1px solid blue;border-radius:25px;' type='text' class='tanggal' name='tglafter' id='tglafter' onchange='cekTanggal()'><br>
							$tglakhir
						</div>";
						echo "
						<div style='clear:both;'>
						<table align=center border=1 class=CSSTableGenerator >
						<tr>
							<td>Id</td><td>Tanggal</td><td>Id User</td><td>Id Target</td><td>Id Barang</td><td>Jumlah</td><td>Status</td>
						</tr>";
						while($hasil = mysql_fetch_array($exquery)){
							echo "<tr>
							<td>".$hasil['Id']."</td>
							<td>".$hasil['Tanggal']."</td>
							<td>".$hasil['Id_User']."</td>
							<td>".$hasil['Id_Target']."</td>
							<td>".$hasil['Id_Barang']."</td>
							<td>".$hasil['Jumlah']."</td>
							<td>".$hasil['Status']."</td>
							</tr>";
						}
						echo "</table></div></form>";
					}
					else{
						echo "Anda tidak berhasil menampilkan data<br>";
					}
				}
				mysql_close($Koneksi->getKonek());
			?>
