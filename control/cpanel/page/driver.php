<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=driver&i=input">Tambah</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "driver/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "driver/edit.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "driver/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "driver/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "driver/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "driver/pdf.php";
		}
		else{
			include "driver/tampil.php";
		}
	?>
</div>
