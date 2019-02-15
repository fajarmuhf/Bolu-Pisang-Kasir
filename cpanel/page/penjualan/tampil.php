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
						echo "<script>window.location='?page=penjualan&i=edit&id=".$_POST['identitas']."'</script>";
					}
					else{
						echo "<script>window.location='?page=penjualan&i=delete&id=".$_POST['identitas']."'</script>";
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
				if(@$_GET['c'] == ""){
					$_GET['c'] = 1;
				}
				
				$Koneksi = new Hubungi();
				$Koneksi->Konek("bolu_pisang");
				
				$pembagi = 5;
				$pembagi2 = 2;
								
				$query = "SELECT * FROM `Penjualan` WHERE Tanggal >= '$tglawal' AND Tanggal <= '$tglakhir' ORDER BY Tanggal DESC LIMIT ".(($_GET['c']-1)*2).",$pembagi";
				$exquery = mysqli_query($Koneksi->getKonek(),$query);
				if($exquery){
					echo "<form action='' id=daftar method=POST >";
					echo "<input type=hidden id=identitas name=identitas>";
					echo "
						<div style='float:left;width:33%;margin-top:15px;'>
							<input style='border:1px solid blue;border-radius:25px;' type='text' class='tanggal' name='tglbefore' id='tglbefore' onchange='cekTanggal()'><br>
							$tglawal
						</div>
						<div style='float:left;width:33%;'>
							<h3>Data - Data Penjualan</h3>
						</div>
						<div style='float:left;width:33%;margin-top:15px;'>
							<input style='border:1px solid blue;border-radius:25px;' type='text' class='tanggal' name='tglafter' id='tglafter' onchange='cekTanggal()'><br>
							$tglakhir
						</div>";
					echo "
					<div style='clear:both;'>
					<table align=center border=1 class=CSSTableGenerator >
					<tr>
						<td>Id</td><td>Tanggal</td><td>Id User</td><td>Id Barang</td><td>Jumlah</td><td>Total</td><td>Aksi</td>
					</tr>";
					$kumpulJumlah = 0;
					$kumpulTotal = 0;
					//$kumpulZakat = 0;
					while($hasil = mysqli_fetch_array($exquery)){
						echo "<tr>
						<td>".$hasil['Id']."</td>
						<td>".$hasil['Tanggal']."</td>
						<td><a href='?page=user'>".$hasil['Id_User']."</a></td>
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
						//$kumpulZakat += $hasil['Zakat'];
					}
					echo "<tr>
							<td></td>
							<td>Total</td>
							<td></td>
							<td></td>
							<td>".$kumpulJumlah."</td>
							<td>".$kumpulTotal."</td>
							<td></td>
					</tr>";
					echo "</table></div>";
					echo "</form>";
					$query0 = "SELECT COUNT(Id) FROM `Penjualan` WHERE Tanggal >= '$tglawal' AND Tanggal <= '$tglakhir' ORDER BY Tanggal ";
					$exquery0 = mysqli_query($Koneksi->getKonek(),$query0);
					if($exquery0){
						$berhasil = mysqli_fetch_array($exquery0);
						if($berhasil[0]%$pembagi == 0){
							for($i=0;$i<($berhasil[0]/$pembagi);$i++){
								echo "<a href=?page=penjualan&i=tampil&c=".($i+1).">".($i+1)."</a>";
							}
						}
						else{
							for($i=0;$i<(($berhasil[0]-($berhasil[0]%$pembagi))/$pembagi)+1;$i++){
								echo "<a href=?page=penjualan&i=tampil&c=".($i+1).">".($i+1)."&nbsp;</a>";
							}
							
						}
					}
					
				}
				else{
					echo "Anda tidak berhasil menampilkan data<br>";
				}
				mysqli_close($Koneksi->getKonek());
			?>
