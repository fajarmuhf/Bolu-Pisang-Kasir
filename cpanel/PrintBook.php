<?php
	session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
	<Title>Ebook Online</title>
	<link rel=stylesheet href="../css/style.css">
	<link rel=stylesheet href="../css/bootstrap.min.css">
	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="../turn.min.js"></script>
	<script type="text/javascript" src="../ajax.js" ></script>
<style type="text/css">
		body{
			background:#ccc;
		}
		#magazine{
			width:576px;
			height:376px;
			margin:20px;
		}
		#magazine .loader{
			background-image:url(../img/loader.gif);
			width:24px;
			height:24px;
			display:block;
			position:absolute;
			top:228px;
			left:188px;
		}
		#magazine .turn-page{
			background-color:#ccc;
			background-size:100% 100%;
		}
		#controls{
			background-color:black;
			float:left;
			width:100px;
			text-align:left;
			margin:20px 20px;
			padding:10px;
			font:13px arial;
			color:white;
			border-radius:20px;
		}
		#controls2{
			background-color:black;
			float:left;
			width:100px;
			text-align:left;
			margin:20px 0px;
			padding:10px;
			font:13px arial;
			color:white;
			border-radius:20px;
		}

		#controls input, #controls label{
			font:13px arial;
		}

		#controls input{
			width:30px;
		}
	</style>
</head>
<body>
			<div id="magazine">
				<div id="boxmagazine" class="cover"><canvas id="the-canvas1" style="width:576px;height:752px;background-color:white;"></canvas>
				<div id="boxmagazine" class="cover"><canvas id="the-canvas2" style="width:576px;height:752px;background-color:white;"></canvas>
				<div id="boxmagazine" class="cover"><canvas id="the-canvas3" style="width:576px;height:752px;background-color:white;"></canvas>
				<div id="boxmagazine" class="cover"><canvas id="the-canvas4" style="width:576px;height:752px;background-color:white;"></canvas>
			</div>
				
			</div>
			<script type="text/javascript" src="../js/pdf.js"></script>
			<script type="text/javascript">				
  			  var url = '<?php echo $_GET['kertas']; ?>';
			  function printsNow(){
				window.print();
			  }
			</script>
			<script type="text/javascript" src="../js/hello_print.js"></script>
</body>
</html>
