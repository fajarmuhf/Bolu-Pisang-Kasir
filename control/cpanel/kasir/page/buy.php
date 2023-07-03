<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=buy&i=beli">Beli</a></li>
		<li class="geser"><a href="?page=buy&i=list">Terbeli</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "beli"){
			include "buy/beli.php";
		}
		else if(@$_GET["i"] == "list"){
			include "buy/list.php";
		}
		else{
			include "buy/beli.php";
		}
	?>
	
</div>
