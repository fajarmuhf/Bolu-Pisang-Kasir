		<?php
			include "page/secure.php";
		?>
		<form action="?page=driver&i=input&kirim=1" method="post" enctype="multipart/form-data">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Input</td>
			</tr>
			<tr>
				<td>Nama : </td><td><input type="text" name="nama" id="nama"></td>
			</tr>
			<tr>
				<td>No Hp : </td><td><input type="text" name="nohp" id="nohp"></td>
			</tr>
			<tr>
				<td>No Plat : </td><td><input type="text" name="noplat" id="noplat"></td>
			<tr>
				<td>Perumahan : </td><td><select name="perum" id="perum">
					<?php
						$Koneksi->Konek("fandystore");
						$kueh = "SELECT * FROM `perumahan` WHERE 1 ";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							while($hasilkueh = mysqli_fetch_array($exkueh)){
								$perumahan = $hasilkueh["nama"];
								echo "<option value='$perumahan'>$perumahan</option>";
							}
						}
					?>
				</select></td>
			</tr>
			<tr>
				<td>Saldo : </td><td><input type="number" name="saldo" id="saldo"></td>
			</tr>
			<tr>
				<td>Status : </td><td><select name="status" id="status">
					<option value="online">online</option>
					<option value="offline">offline</option>
				</select></td>
			</tr>
			<tr>
				<td>Foto : </td><td><input type="file" name="foto" id="foto"></td>
			</tr>
			<tr>
				<td>Tanggal Daftar : </td><td><input type="datetime-local" name="tanggaldaftar" id="tanggaldaftar"></td>
			</tr>
			<tr>
				<td>Username : </td><td><input type="text" name="username" id="username"></td>
			</tr>
			<tr>
				<td>Password : </td><td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
				<td>Last Online : </td><td><input type="datetime-local" name="lastonline" id="lastonline"></td>
			</tr>
			<tr>
				<td>Pencarian : </td><td><input type="number" name="pencarian" id="pencarian"></td>
			</tr>
			<tr>
				<td>Pesanan Aktif : </td><td><input type="number" name="pesananaktif" id="pesananaktif"></td>
			</tr>
			<tr>
				<td>Max Pesanan : </td><td><input type="number" name="maxpesanan" id="maxpesanan"></td>
			</tr>
			<tr>
				<td>Banned : </td><td><input type="datetime-local" name="banned" id="banned"></td>
			</tr>
			<tr>
				<td>Latitude : </td><td><input type="text" name="latitude" id="latitude"></td>
			</tr>
			<tr>
				<td>Longitude : </td><td><input type="text" name="longitude" id="longitude"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/user.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["username"] != "" && @$_POST["password"] != "" && @$_POST["status"] != "" && @$_POST["perum"] != ""){
						$kueh = "SELECT (COUNT(*)+1) FROM `driver` WHERE 1 ";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							$hasilkueh = mysqli_fetch_array($exkueh);
							$nama = $_POST["nama"];
							$nohp = ($_POST["nohp"]);
							$noplat = ($_POST["noplat"]);
							$status = $_POST["status"];
							$saldo = $_POST["saldo"];
							$perum = $_POST["perum"];
							$foto = $_FILES["foto"]["name"];
							$tanggaldaftar = date('Y-m-d H:i:s',strtotime($_POST["tanggaldaftar"]));
							$username = $_POST["username"];
							$password = $_POST["password"];
							$lastonline = date('Y-m-d H:i:s',strtotime($_POST["lastonline"]));
							$pencarian = $_POST["pencarian"];
							$pesananaktif = $_POST["pesananaktif"];
							$maxpesanan = $_POST["maxpesanan"];
							$banned = date('Y-m-d H:i:s',strtotime($_POST["banned"]));
							$latitude = $_POST["latitude"];
							$longitude = $_POST["longitude"];
								
							$query = "INSERT INTO `driver` SELECT (COUNT(*)+1),?,?,?,?,?,?,null,?,?,?,?,?,?,?,?,'',?,? FROM `driver` WHERE 1 ";
							$exquery=$Koneksi->getKonek()->prepare($query);
							$exquery->bind_param("ssssisssssiiisss",$nama,$nohp,$noplat,$perum,$saldo,$status,$tanggaldaftar,$username,$password,$lastonline,$pencarian,$pesananaktif,$maxpesanan,$banned,$latitude,$longitude);
							$result = $exquery->execute();
							if($result){
								if(file_exists("../../images/driver/" . $username . ".png")){
									unlink("../../images/driver/" . $username . ".png");
								}
								move_uploaded_file($_FILES["foto"]["tmp_name"],"../../images/driver/" . $username . ".png");	
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
