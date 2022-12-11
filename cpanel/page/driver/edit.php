		<?php
			include "page/secure.php";
		?>
		<form action="?page=driver&i=edit&kirim=1" method="post" enctype="multipart/form-data">
			<input type="hidden" name="atribut" id="atribut" value="id">
			<input type="hidden" name="nilai" id="nilai">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Edit</td>
			</tr>
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
				<td>Pencairan : </td><td><input type="number" name="pencarian" id="pencarian"></td>
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
				<td colspan=2><button class="button"> Edit </button></td>
			</tr>
			</table>
			<?php
				include "include/user.php";
				$Koneksi->Konek("fandystore");
				
				if(isset($_GET['id'])){
					$kueh = "SELECT * FROM `driver` WHERE Id = ".$_GET['id'];
					$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
					if($exkueh){
						while($hasil = mysqli_fetch_array($exkueh)){
							echo "<script>";
							echo "document.getElementById('nama').value='".$hasil['nama']."';";
							echo "document.getElementById('nohp').value='".$hasil['nohp']."';";
							echo "document.getElementById('noplat').value='".$hasil['noplat']."';";
							echo "document.getElementById('status').value='".$hasil['status']."';";
							echo "document.getElementById('saldo').value='".$hasil['saldo']."';";
							echo "document.getElementById('perum').value='".$hasil['perum']."';";
							echo "document.getElementById('tanggaldaftar').value='".date('Y-m-d\TH:i:s',strtotime($hasil['tanggaldaftar']))."';";
							echo "document.getElementById('username').value='".$hasil['username']."';";
							echo "document.getElementById('password').value='".$hasil['password']."';";
							echo "document.getElementById('lastonline').value='".date('Y-m-d\TH:i:s',strtotime($hasil['last_online']))."';";
							echo "document.getElementById('pencarian').value='".$hasil['pencarian']."';";
							echo "document.getElementById('pesananaktif').value='".$hasil['pesanan_aktif']."';";
							echo "document.getElementById('maxpesanan').value='".$hasil['maxpesanan']."';";
							echo "document.getElementById('banned').value='".date('Y-m-d\TH:i:s',strtotime($hasil['banned']))."';";
							echo "document.getElementById('latitude').value='".$hasil['latitude']."';";
							echo "document.getElementById('longitude').value='".$hasil['longitude']."';";
							echo "</script>";
						}
					}
				}

				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["username"] != "" && @$_POST["password"] != "" && @$_POST["status"] != ""  && @$_POST["perum"] != "" &&
					@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("fandystore");
						
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
						
						$kueh = "SELECT * FROM `driver` WHERE id = ?";
						$exquery=$Koneksi->getKonek()->prepare($kueh);
						$exquery->bind_param("i",$nilai);
						$result = $exquery->execute();

						if($result){
							$hasil = $exquery->get_result()->fetch_all(MYSQLI_ASSOC);
							if(true){
								$kueh2 = "SELECT id FROM `driver` WHERE id = ? ";
								$exquery2=$Koneksi->getKonek()->prepare($kueh2);
								$exquery2->bind_param("i",$nilai);
								$result2 = $exquery2->execute();
								if($result2){
									$hasilkueh = $exquery2->get_result()->fetch_all(MYSQLI_ASSOC);
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
															
									$query = "UPDATE `driver` SET nama = ?,nohp = ?,noplat = ?,perum = ?,saldo = ?,saldo = ?,tanggaldaftar = ?,username = ?,password = ?,last_online = ?,pencarian = ?,pesanan_aktif = ?,maxpesanan = ?,banned = ?,latitude = ?,longitude = ? WHERE id = ? ";
									$exquery=$Koneksi->getKonek()->prepare($query);
									$exquery->bind_param("ssssisssssiiisssi",$nama,$nohp,$noplat,$perum,$saldo,$status,$tanggaldaftar,$username,$password,$lastonline,$pencarian,$pesananaktif,$maxpesanan,$banned,$latitude,$longitude,$nilai);
									$result = $exquery->execute();
									if($result){
										if(file_exists("../../images/driver/" . $username . ".png")){
											unlink("../../images/driver/" . $username . ".png");
										}
										move_uploaded_file($_FILES["foto"]["tmp_name"],"../../images/driver/" . $username . ".png");	
										echo "Anda telah berhasil mengedit data<br>";
									}
									else{
										echo "Anda tidak berhasil mengedit data<br>";
									}
								}
								else{
									echo "Anda tidak berhasil menginput data<br>";
								}
							}
						}
						mysqli_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
