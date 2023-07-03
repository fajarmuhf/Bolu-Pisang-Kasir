<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=aset&i=input">Tambah</a></li>
		<?php
			include "aset/inputsearch.php";
		?>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "aset/input.php";
		}
		else if(@$_GET["i"] == "edit"){
			include "aset/edit.php";
		}
		else if(@$_GET["i"] == "salin"){
			include "aset/salin.php";
		}
		else if(@$_GET["i"] == "delete"){
			include "aset/delete.php";
		}
		else if(@$_GET["i"] == "tampil"){
			include "aset/tampil.php";
		}
		else if(@$_GET["i"] == "grafik"){
			include "aset/grafik.php";
		}
		else if(@$_GET["i"] == "pdf"){
			include "aset/pdf.php";
		}
		else{
			include "aset/tampil.php";
		}
	?>
</div>
