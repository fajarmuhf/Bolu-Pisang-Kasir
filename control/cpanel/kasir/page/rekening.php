<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=rekening&i=input">Input</a></li>
		<li class="geser"><a href="?page=rekening&i=edit">Edit</a></li>
		<li class="geser"><a href="?page=rekening&i=delete">Delete</a></li>
		<li class="geser"><a href="?page=rekening&i=tampil">Tampil</a></li>
		<li class="geser"><a href="?page=rekening&i=grafik">Grafik</a></li>
		<li class="geser"><a href="?page=rekening&i=pdf">PDF</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "rekening/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "rekening/edit.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "rekening/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "rekening/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "rekening/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "rekening/pdf.php";
		}
		else{
			include "rekening/tampil.php";
		}
	?>
</div>
