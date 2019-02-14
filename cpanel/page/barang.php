<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=barang&i=input">Input</a></li>
		<li class="geser"><a href="?page=barang&i=edit">Edit</a></li>
		<li class="geser"><a href="?page=barang&i=delete">Delete</a></li>
		<li class="geser"><a href="?page=barang&i=tampil">Tampil</a></li>
		<li class="geser"><a href="?page=barang&i=grafik">Grafik</a></li>
		<li class="geser"><a href="?page=barang&i=pdf">PDF</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "barang/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "barang/edit.php";
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
