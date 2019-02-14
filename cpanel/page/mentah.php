<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=mentah&i=input">Input</a></li>
		<li class="geser"><a href="?page=mentah&i=edit">Edit</a></li>
		<li class="geser"><a href="?page=mentah&i=delete">Delete</a></li>
		<li class="geser"><a href="?page=mentah&i=tampil">Tampil</a></li>
		<li class="geser"><a href="?page=mentah&i=grafik">Grafik</a></li>
		<li class="geser"><a href="?page=mentah&i=pdf">PDF</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "mentah/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "mentah/edit.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "mentah/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "mentah/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "mentah/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "mentah/pdf.php";
		}
		else{
			include "mentah/tampil.php";
		}
	?>
</div>
