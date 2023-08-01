		<form action="?page=penjualan&i=restock&kirim=1" method="post">
			<input type="hidden" name="atribut" id="atribut" value="id">
			<input type="hidden" name="nilai" id="nilai">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Delete</td>
			</tr>
			<tr>
				<td colspan="2">Yakin ingin merestock ?.</td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Restock </button></td>
			</tr>
			</table>
			<?php
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["id"] != ""){
						$Koneksi->Konek("fandystore");
						
						$nilai = $_GET["id"];

						$kueh = "SELECT * FROM clientorder as A,cart as B WHERE A.uang_diterima IS NULL AND A.id = ? AND A.id = B.orderid";
						$exquery=$Koneksi->getKonek()->prepare($kueh);
						$exquery->bind_param("i",$nilai);
						$exkueh = $exquery->execute();
						if($exkueh){
							$hasil = $exquery->get_result()->fetch_all(MYSQLI_ASSOC);
							$query = "UPDATE clientorder SET uang_diterima = 'sudah' WHERE id = ? ";
							$exquery21=$Koneksi->getKonek()->prepare($query);
							$exquery21->bind_param("i",$nilai);
							$exquery = $exquery21->execute();
							echo "<script>window.location='?page=penjualan&i=history'</script>";
						}
						else{
							echo "Anda tidak berhasil menerima uang data<br>";
						}
					}
			?>
		</form>
