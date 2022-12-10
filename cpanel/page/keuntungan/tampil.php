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
				
				$_SESSION['tglbefore'] = $tglawal;
				$_SESSION['tglafter'] = $tglakhir;
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("bolu_pisang");
								
				$query = "SELECT SUM(A.Total),SUM(B.Total),(SUM(B.Total)-SUM(A.Total)),((SUM(B.Total)-SUM(A.Total))*2.5/100) FROM `Pengeluaran` as A,Penjualan as B WHERE A.Tanggal >= '$tglawal' AND A.Tanggal <= '$tglakhir' AND B.Tanggal >= '$tglawal' AND B.Tanggal <= '$tglakhir'";
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
							<h3>Data - Data Keuntungan</h3>
						</div>
						<div style='float:left;width:33%;margin-top:15px;'>
							<input style='border:1px solid blue;border-radius:25px;' type='text' class='tanggal' name='tglafter' id='tglafter' onchange='cekTanggal()'><br>
							$tglakhir
						</div>";
					echo "
					<div style='clear:both;'>
					<table align=center border=1 class=CSSTableGenerator >
					<tr>
						<td>Pengeluaran</td><td>Penjualan</td><td>Keuntungan</td><td>Zakat</td>
					</tr>";
					while($hasil = mysql_fetch_array($exquery)){
						echo "<tr>
						<td>".$hasil[0]."</td>
						<td>".$hasil[1]."</td>
						<td>".$hasil[2]."</td>
						<td>".$hasil[3]."</td>
						</tr>";
					}
					echo "</table></div>";
					echo "</form>";
				}
				else{
					echo "Anda tidak berhasil menampilkan data<br>";
				}
				mysql_close($Koneksi->getKonek());
			?>
