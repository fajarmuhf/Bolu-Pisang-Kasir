			<div id="magazine">
				<div id="boxmagazine" class="cover"><canvas id="the-canvas1" style="width:288px;height:376px;background-color:white;"></canvas></div>
				
			</div>
			<script type="text/javascript" src="../js/pdf.js"></script>
			<script type="text/javascript">				
  			  var url = 'page/pengiriman/pdfbook.php?tglbefore=<?php echo str_replace(':','/',($_SESSION['tglbefore']));?>&tglafter=<?php echo str_replace(':','/',($_SESSION['tglafter']));?>';
			</script>
			<script type="text/javascript" src="../js/hello.js"></script>
			<script type="text/javascript" src="../js/ajax.js" ></script>
			<script type="text/javascript" src="../js/Main_turn.js"></script>

			<div id="controls">
				<label for="page-number">Page </label> <span id="number-page"></span>  of <span id="number-pages"></span>
			</div>
			<div id="controls2">	
			<image src="../img/next.png" onclick="goNext()" title=next style="width:30px;height:30px;">
			<image src="../img/prev.png" onclick="goPrev()" title=prev style="width:30px;height:30px;">
			<image src="../img/zoomin.png" onclick="ZoomIns()" title="zoom in" style="width:30px;height:30px;">
			<input type="text" size="3" id="page-number1">
			<image src="../img/zoomout.png" onclick="ZoomOuts()" title="zoom out" style="width:30px;height:30px;">
			<image src="../img/print.png" onclick="return popitup('PrintBook.php?kertas=page/pengiriman/pdfbook.php?tglbefore=<?php echo str_replace(':','/',($_SESSION['tglbefore']));?>&tglafter=<?php echo str_replace(':','/',($_SESSION['tglafter']));?>')" title="print" style="width:30px;height:30px;">
			<image src="../img/download.png" onclick="window.open('page/pengiriman/pdfbook.php?tglbefore=<?php echo str_replace(':','/',($_SESSION['tglbefore']));?>&tglafter=<?php echo str_replace(':','/',($_SESSION['tglafter']));?>','_blank');" title="download" style="width:30px;height:30px;">
			</div>
