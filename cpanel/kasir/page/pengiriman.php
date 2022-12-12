<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=pengiriman&i=tampil">Tampil</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "tampil"){
			include "pengiriman/tampil.php";
		}
		else{
			include "pengiriman/tampil.php";
		}
	?>
</div>
