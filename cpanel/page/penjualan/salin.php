		<form action="?page=barang&i=input&kirim=1" method="post" enctype="multipart/form-data">
			<input type="hidden" name="atribut" id="atribut" value="id">
			<input type="hidden" name="nilai" id="nilai">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Tambah</td>
			</tr>
			<tr>
				<td>Nama : </td><td><input type="text" name="nama" id="nama"></td>
			</tr>
			<tr>
				<td>Deskripsi : </td><td><textarea type="text" name="deskripsi" id="deskripsi"></textarea></td>
			</tr>
			<tr>
				<td>Stok : </td><td><input type="number" name="stok" id="stok"></td>
			</tr>
			<tr>
				<td>Satuan : </td><td><input type="text" name="satuan" id="satuan"></td>
			</tr>
			<tr>
				<td>Harga : </td><td><input type="number" name="harga" id="harga"></td>
			</tr>
			<tr>
				<td>Perum : </td><td><input type="text" name="perum" id="perum"></td>
			</tr>
			<tr>
				<td>Tag : </td><td><input type="text" name="tag" id="tag"></td>
			</tr>
			<tr>
				<td>Jumlah Klik : </td><td><input type="number" name="jumlahklik" id="jumlahklik"></td>
			</tr>
			<tr>
				<td>Gambar : </td><td><input type="file" name="gambar" id="gambar"></td>
			</tr>
			<tr>
				<td>Expire : </td><td><input type="date" name="expire" id="expire"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Tambah </button></td>
			</tr>
			</table>
			<?php
				include "include/barang.php";
				$Koneksi->Konek("fandystore");
				
				if(isset($_GET['id'])){
					$kueh = "SELECT * FROM produk WHERE id = ".$_GET['id'];
					$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
					if($exkueh){
						while($hasil = mysqli_fetch_array($exkueh)){
							echo "<script>";
							echo "document.getElementById('nama').value='".$hasil['nama']."';";
							echo "document.getElementById('deskripsi').innerHTML='".$hasil['deskripsi']."';";
							echo "document.getElementById('stok').value=".$hasil['stock'].";";
							echo "document.getElementById('satuan').value='".$hasil['satuan']."';";
							echo "document.getElementById('harga').value=".$hasil['harga'].";";
							echo "document.getElementById('perum').value='".$hasil['perum']."';";
							echo "document.getElementById('tag').value='".$hasil['tag']."';";
							echo "document.getElementById('jumlahklik').value=".$hasil['jumlahklik'].";";
							echo "document.getElementById('expire').value='".$hasil['expdate']."';";
							echo "</script>";
						}
					}
				}

				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
			?>
		</form>
