<?php
	session_start();

	include "../secure.php";
	include "../../../include/koneksi.php";
	$Koneksi = new Hubungi();
	$Koneksi->Konek("fandystore");
				
	if(isset($_POST['start']) && @$_POST['start'] >= 0){		
		$start = $_POST['start'];		
		if(isset($_POST['key']) && @$_POST['key'] != ""){
			$key = "%".$_POST['key']."%";
				
			$query = "SELECT * FROM `driver` WHERE username LIKE ? limit ?,3";
			$exquery=$Koneksi->getKonek()->prepare($query);
			$exquery->bind_param("si",$key,$start);	
		
		}
		else{
			$query = "SELECT * FROM `driver` WHERE 1 limit ?,3 ";
			$exquery=$Koneksi->getKonek()->prepare($query);
			$exquery->bind_param("i",$start);	
		}
		$result = $exquery->execute();
		if($result){
			$html = "";
			$hasil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
			if(count($hasil) > 0){
				if($start == 0){
					$html .= "<div style='overflow-x: scroll;'>";
					$html .= "<table align=center border=1 id=tabelku class=CSSTableGenerator >
								<tr><td>Id</td><td>Nama</td><td>No Hp</td><td>No Plat</td><td>Perum</td><td>Saldo</td><td>Status</td><td>Foto</td><td>Tanggal Daftar</td><td>Username</td><td>Password</td><td>Last Online</td><td>Pencairan</td><td>Pesanan Aktif</td><td>Max Pesanan</td><td>Banned</td><td>Fcm Token</td><td>Lat</td><td>Long</td><td>Aksi</td></tr>";
				}
				for($i=0;$i<count($hasil);$i++){
					$html .= "<tr>
							<td>".$hasil[$i]['id']."</td>
							<td>".$hasil[$i]['nama']."</td>
							<td>".$hasil[$i]['nohp']."</td>
							<td>".$hasil[$i]['noplat']."</td>
							<td>".$hasil[$i]['perum']."</td>
							<td>".$hasil[$i]['saldo']."</td>
							<td>".$hasil[$i]['status']."</td>";
					if (file_exists("../../../../images/driver/".$hasil[$i]['username'].".png"))
					{
						$html .= "<td><a href='../../images/driver/".$hasil[$i]['username'].".png'  onclick='return hs.expand(this)' class='highslide'><img src='../../images/driver/".$hasil[$i]['username'].".png' width=90px height=120px ></a></td>";
					}
					else{
						$html .= "<td></td>";
					}
					$html .= "<td>".$hasil[$i]['tanggaldaftar']."</td>
							<td>".$hasil[$i]['username']."</td>
							<td>".$hasil[$i]['password']."</td>
							<td>".$hasil[$i]['last_online']."</td>
							<td>".$hasil[$i]['pencarian']."</td>
							<td>".$hasil[$i]['pesanan_aktif']."</td>
							<td>".$hasil[$i]['maxpesanan']."</td>
							<td>".$hasil[$i]['banned']."</td>
							<td>".$hasil[$i]['fcmtoken']."</td>
							<td>".$hasil[$i]['latitude']."</td>
							<td>".$hasil[$i]['longitude']."</td>";
					$html .= "
						<td>
							<select id='Aksi".$hasil[$i]['id']."' name='Aksi".$hasil[$i]['id']."' onChange=document.getElementById('Aksi".$hasil[$i]['id']."').name='Aksi';document.getElementById('identitas').value='".$hasil[$i]['id']."';document.getElementById('daftar').submit() >
								<option value=''>--pilih aksi--</option>
								<option value='edit'>Edit</option>
								<option value='hapus'>Hapus</option>
							</select>
						</td></tr>";
				}
				if($start == 0){
					$html .= "</table>";
					$html .= "</div>";
				}
			}
			echo $html;
		}
	}
?>