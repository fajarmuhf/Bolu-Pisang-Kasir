<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=pengeluaran&i=input">Input</a></li>
		<li class="geser"><a href="?page=pengeluaran&i=edit">Edit</a></li>
		<li class="geser"><a href="?page=pengeluaran&i=delete">Delete</a></li>
		<li class="geser"><a href="?page=pengeluaran&i=tampil">Tampil</a></li>
		<li class="geser"><a href="?page=pengeluaran&i=grafik">Grafik</a></li>
		<li class="geser"><a href="?page=pengeluaran&i=pdf">PDF</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "pengeluaran/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "pengeluaran/edit.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "pengeluaran/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "pengeluaran/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "pengeluaran/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "pengeluaran/pdf.php";
		}
		else{
			include "pengeluaran/tampil.php";
		}
	?>
</div>
