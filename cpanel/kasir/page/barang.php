<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=barang&i=tampil">Tampil</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "tampil"){
			include "barang/tampil.php";
		}
		else{
			include "barang/tampil.php";
		}
	?>
</div>
