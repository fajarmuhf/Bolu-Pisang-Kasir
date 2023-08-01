		<?php
			include "page/secure.php";
		?>
		<form action="?page=user&i=input2&kirim=1" method="post" enctype="multipart/form-data">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Ganti Cabang</td>
			</tr>
			<tr>
				<td>Cabang : </td><td><select name="perum" id="perum">
					<?php
						$Koneksi->Konek("fandystore");
						
						$username = $_SESSION['username'];
						$password = $_SESSION["password"];

						$query="SELECT Id,Perum FROM `user-manager` WHERE Username = ? AND Password = ?";

						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$username,$password);
						$exquery->execute();
						
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
							$perumold = $tampil[0]["Perum"];
						}

						$kueh = "SELECT * FROM `perumahan` WHERE 1 ";
						$exkueh = mysqli_query($Koneksi->getKonek(),$kueh);
						if($exkueh){
							while($hasilkueh = mysqli_fetch_array($exkueh)){
								$perumahan = $hasilkueh["nama"];
								if(strcmp($perumold, $perumahan) == 0){
									echo "<option value='$perumahan' selected>$perumahan</option>";
								}
								else{
									echo "<option value='$perumahan'>$perumahan</option>";
								}
							}
						}
					?>
				</select></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Ubah </button></td>
			</tr>
			</table>
			<?php
				include "include/user.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["perum"] != ""){
						$perum = ($_POST["perum"]);

						

						$query = "UPDATE `user-manager` SET Perum = ? WHERE Id = ?";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$perum,$iduser);
						$result = $exquery->execute();
						if($result){
							echo "<script>
								document.getElementById('perum').value='$perum';
								Swal.fire({
								    toast: true,
								    icon: 'success',
								    title: 'Sukses',
								    animation: false,
								    position: 'bottom',
								    showConfirmButton: false,
								    timer: 3000,
								    timerProgressBar: true,
								    didOpen: (toast) => {
								      toast.addEventListener('mouseenter', Swal.stopTimer)
								      toast.addEventListener('mouseleave', Swal.resumeTimer)
								    }
								  })</script>";
						}
						else{
							echo "<script>Swal.fire({
								    toast: true,
								    icon: 'error',
								    title: 'Gagal',
								    animation: false,
								    position: 'bottom',
								    showConfirmButton: false,
								    timer: 3000,
								    timerProgressBar: true,
								    didOpen: (toast) => {
								      toast.addEventListener('mouseenter', Swal.stopTimer)
								      toast.addEventListener('mouseleave', Swal.resumeTimer)
								    }
								  })</script>";
						}
						 
									
						mysqli_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
