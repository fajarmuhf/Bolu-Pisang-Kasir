<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=user&i=input">Input</a></li>
		<li class="geser"><a href="?page=user&i=edit">Edit</a></li>
		<li class="geser"><a href="?page=user&i=delete">Delete</a></li>
		<li class="geser"><a href="?page=user&i=tampil">Tampil</a></li>
		<li class="geser"><a href="?page=user&i=grafik">Grafik</a></li>
		<li class="geser"><a href="?page=user&i=pdf">PDF</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "user/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "user/edit.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "user/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "user/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "user/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "user/pdf.php";
		}
		else{
			include "user/tampil.php";
		}
	?>
</div>
