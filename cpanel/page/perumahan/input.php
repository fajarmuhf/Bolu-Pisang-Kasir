		<?php
			include "page/secure.php";
		?>
		<form action="?page=perumahan&i=input&kirim=1" method="post" enctype="multipart/form-data">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Tambah</td>
			</tr>
			<tr>
				<td>Nama : </td><td><input type="text" name="nama" id="nama"></td>
			</tr>
			<tr>
				<td>Lokasi : </td><td><input type="text" name="lokasi" id="lokasi"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/user.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["nama"] != "" && @$_POST["lokasi"] != ""){
						$Koneksi->Konek("fandystore");
						$kueh = "SELECT (COUNT(*)) FROM `perumahan` WHERE 1 ";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							$hasilkueh = mysqli_fetch_array($exkueh);
							$nama = $_POST["nama"];
							$lokasi = ($_POST["lokasi"]);
								
							$query = "INSERT INTO `perumahan` SELECT (COUNT(*)+1),?,? FROM `perumahan` WHERE 1 ";
							$exquery=$Koneksi->getKonek()->prepare($query);
							$exquery->bind_param("ss",$nama,$lokasi);
							$result = $exquery->execute();
							if($result){
								echo "Anda telah berhasil menginput data<br>";
							}
							else{
								echo "Anda tidak berhasil menginput data<br>";
							}
							 
						}
						else{
							echo "Anda tidak berhasil menginput data<br>";
						}			
						mysqli_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
