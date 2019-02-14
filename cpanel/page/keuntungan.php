<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=keuntungan&i=tampil">Tampil</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "tampil"){
			include "keuntungan/tampil.php";
		}
		else{
			include "keuntungan/tampil.php";
		}
	?>
</div>
