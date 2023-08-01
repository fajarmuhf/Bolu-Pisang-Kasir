<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=investasi&i=input">Tambah</a></li>
		<?php
			include "investasi/inputsearch.php";
		?>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "investasi/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "investasi/edit.php";
		}
		else if(@$_GET["i"] == "salin"){
			include "investasi/salin.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "investasi/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "investasi/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "investasi/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "investasi/pdf.php";
		}
		else{
			include "investasi/tampil.php";
		}
	?>
</div>
