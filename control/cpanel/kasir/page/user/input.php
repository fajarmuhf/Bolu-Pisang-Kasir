		<?php
			include "page/secure.php";
		?>
		<form action="?page=user&i=input&kirim=1" method="post" enctype="multipart/form-data">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Ganti Password</td>
			</tr>
			<tr>
				<td>Password Baru : </td><td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Ubah </button></td>
			</tr>
			</table>
			<?php
				include "include/user.php";
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["password"] != ""){
						$username = $_SESSION['username'];
						$password = $_SESSION["password"];
						$pass = md5($_POST["password"]);

						$query="SELECT Id FROM `user-manager` WHERE Username = ? AND Password = ?";
						$Koneksi->Konek("fandystore");

						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$username,$password);
						$exquery->execute();
						
						if($exquery){
							$tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

							$iduser = $tampil[0]["Id"];
						}

						$query = "UPDATE `user-manager` SET Password = ? WHERE Id = ?";
						$exquery=$Koneksi->getKonek()->prepare($query);
						$exquery->bind_param("ss",$pass,$iduser);
						$result = $exquery->execute();
						if($result){
							echo "<script>Swal.fire({
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
