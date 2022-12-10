<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=stok&i=input">Input</a></li>
		<li class="geser"><a href="?page=stok&i=edit">Edit</a></li>
		<li class="geser"><a href="?page=stok&i=delete">Delete</a></li>
		<li class="geser"><a href="?page=stok&i=tampil">Tampil</a></li>
		<li class="geser"><a href="?page=stok&i=grafik">Grafik</a></li>
		<li class="geser"><a href="?page=stok&i=pdf">PDF</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "stok/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "stok/edit.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "stok/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "stok/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "stok/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "stok/pdf.php";
		}
		else{
			include "stok/tampil.php";
		}
	?>
</div>
