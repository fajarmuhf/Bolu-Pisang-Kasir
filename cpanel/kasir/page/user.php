<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=user&i=tampil">Tampil</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "tampil"){
			include "user/tampil.php";
		}
		else{
			include "user/tampil.php";
		}
	?>
</div>
