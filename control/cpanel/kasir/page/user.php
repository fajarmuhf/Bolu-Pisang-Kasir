<div id="sidebar">
	<ul>
		<li class="geser"><a href="?page=user&i=input">Ganti Password</a></li>
		<li class="geser"><a href="?page=user&i=input2">Ganti Cabang</a></li>
	</ul>
</div>
<div id="content">
	<?php
		if(@$_GET["i"] == "input"){
			include "user/input.php";
		}
		else if(@$_GET["i"] == "input2"){
			include "user/input2.php";
		}
		else{
			include "user/tampil.php";
		}
	?>
</div>
