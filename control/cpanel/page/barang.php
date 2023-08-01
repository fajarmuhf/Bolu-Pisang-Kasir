<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=barang&i=input">Tambah</a></li>
		<li class="geser"><a href="?page=barang&i=input2">Salin Perum</a></li>
		<?php
			include "barang/inputsearch.php";
		?>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "barang/input.php";
		}
		else if(@$_GET["i"] == "input2"){
			include "barang/input2.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "barang/edit.php";
		}
		else if(@$_GET["i"] == "salin"){
			include "barang/salin.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "barang/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "barang/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "barang/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "barang/pdf.php";
		}
		else{
			include "barang/tampil.php";
		}
	?>
</div>
