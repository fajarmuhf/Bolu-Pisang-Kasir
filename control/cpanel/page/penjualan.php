<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=penjualan&i=history">Penjualan</a></li>
		<li class="geser"><a href="?page=penjualan&i=pengiriman">Harian</a></li>
		<li class="geser"><a href="?page=penjualan&i=tampil">Notifikasi</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "penjualan/input.php";
		}
		else if(@$_GET["i"] == "input2"){
			include "penjualan/input2.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "penjualan/edit.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "penjualan/delete.php";
		}
		else if(@$_GET["i"] == "delete2"){
			include "penjualan/delete2.php";
		}
		else if(@$_GET["i"] == "delete3"){
			include "penjualan/delete3.php";
		}
		else if(@$_GET["i"] == "restock"){
			include "penjualan/restock.php";
		}
		else if(@$_GET["i"] == "pengiriman"){
			include "penjualan/pengiriman.php";
		}
		else if(@$_GET["i"] == "terimauang"){
			include "penjualan/terimauang.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "penjualan/tampil.php";
		}
		else if(@$_GET["i"] == "history"){
			include "penjualan/history.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "penjualan/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "penjualan/pdf.php";
		}
		else{
			include "penjualan/history.php";
		}
	?>
</div>
