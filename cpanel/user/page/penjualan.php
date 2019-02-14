<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=penjualan&i=input">Input</a></li>
		<li class="geser"><a href="?page=penjualan&i=tampil">Tampil</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "penjualan/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "penjualan/edit.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "penjualan/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "penjualan/tampil.php";
		}
		else{
			include "penjualan/tampil.php";
		}
	?>
</div>
