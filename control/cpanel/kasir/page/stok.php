<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=stok&i=cek">Cek</a></li>
		<li class="geser"><a href="?page=stok&i=tampil">Tampil</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "cek"){
			include "stok/cek.php";
		}
		else if(@$_GET["i"] == "validcek"){
			include "stok/validcek.php";
		}
		else if(@$_GET["i"] == "kirim"){
			include "stok/kirim.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "stok/tampil.php";
		}
		else{
			include "stok/tampil.php";
		}
	?>
</div>
