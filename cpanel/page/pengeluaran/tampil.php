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
						echo "<script>window.location='?page=pengeluaran&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else{
						echo "<script>window.location='?page=pengeluaran&i=delete&id=".$_POST['identitas']."'</script>";
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
				
				$_SESSION['tglbefore'] = $tglawal;
				$_SESSION['tglafter'] = $tglakhir;
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("bolu_pisang");
								
				$query = "SELECT * FROM `Pengeluaran` WHERE Tanggal >= '$tglawal' AND Tanggal <= '$tglakhir' ORDER BY Tanggal ";
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
							<h3>Data - Data Pengeluaran</h3>
						</div>
						<div style='float:left;width:33%;margin-top:15px;'>
							<input style='border:1px solid blue;border-radius:25px;' type='text' class='tanggal' name='tglafter' id='tglafter' onchange='cekTanggal()'><br>
							$tglakhir
						</div>";
					echo "
					<div style='clear:both;'>
					<table align=center border=1 class=CSSTableGenerator >
					<tr>
						<td>Id</td><td>Tanggal</td><td>Id Barang</td><td>Jumlah</td><td>Total</td><td>Aksi</td>
					</tr>";
					$kumpulJumlah = 0;
					$kumpulTotal = 0;
					$kumpulZakat = 0;
					while($hasil = mysql_fetch_array($exquery)){
						echo "<tr>
						<td>".$hasil['Id']."</td>
						<td>".$hasil['Tanggal']."</td>
						<td><a href='?page=barang'>".$hasil['Id_Barang']."</a></td>
						<td>".$hasil['Jumlah']."</td>
						<td>".$hasil['Total']."</td>
						<td>
							<select id='Aksi".$hasil['Id']."' name='Aksi".$hasil['Id']."' onChange=document.getElementById('Aksi".$hasil['Id']."').name='Aksi';document.getElementById('identitas').value='".$hasil['Id']."';document.getElementById('daftar').submit() >
								<option value=''>--pilih aksi--</option>
								<option value='edit'>Edit</option>
								<option value='hapus'>Hapus</option>
							</select>
						</td>
						</tr>";
						$kumpulJumlah += $hasil['Jumlah'];
						$kumpulTotal += $hasil['Total'];
					}
					echo "<tr>
							<td></td>
							<td>Total</td>
							<td></td>
							<td>".$kumpulJumlah."</td>
							<td>".$kumpulTotal."</td>
							<td></td>
					</tr>";
					echo "</table></div>";
					echo "</form>";
				}
				else{
					echo "Anda tidak berhasil menampilkan data<br>";
				}
				mysql_close($Koneksi->getKonek());
			?>
