<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=perumahan&i=input">Tambah</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "perumahan/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "perumahan/edit.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "perumahan/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "perumahan/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "perumahan/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "perumahan/pdf.php";
		}
		else{
			include "perumahan/tampil.php";
		}
	?>
</div>
