<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=pengiriman&i=input">Input</a></li>
		<li class="geser"><a href="?page=pengiriman&i=edit">Edit</a></li>
		<li class="geser"><a href="?page=pengiriman&i=delete">Delete</a></li>
		<li class="geser"><a href="?page=pengiriman&i=tampil">Tampil</a></li>
		<li class="geser"><a href="?page=pengiriman&i=grafik">Grafik</a></li>
		<li class="geser"><a href="?page=pengiriman&i=pdf">PDF</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "pengiriman/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "pengiriman/edit.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "pengiriman/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "pengiriman/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "pengiriman/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "pengiriman/pdf.php";
		}
		else{
			include "pengiriman/tampil.php";
		}
	?>
</div>
