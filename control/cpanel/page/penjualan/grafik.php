<h1 class='title'>Grafik Penjualan</h1>";
<div style="margin:auto;text-align: center;width: 80%;">
	<div>
		<p class="titlegraph">Bar Graph</p>
		<a href="page/penjualan/grafik/BarGraph.php" class="highslide" onclick="
		function LoadImage(){
			try{
			hs.expanders[hs.expanders.length-1].doFullExpand();
			var startCoords = {}, endCoords = {};
			var tmpX = $('[id^=highslide-wrapper]').position().left, tmpY = $('[id^=highslide-wrapper]').position().top;
			var rectmpX =0 ,rectmpY = 0;

			var startCoords = {}, endCoords = {};
			$('[id^=highslide-wrapper]').bind('touchstart', function(event) {
			    endCoords = event.originalEvent.targetTouches[0];
			    startCoords.pageX = event.originalEvent.targetTouches[0].pageX;
			    startCoords.pageY = event.originalEvent.targetTouches[0].pageY;
			});

			$('[id^=highslide-wrapper]').bind('touchmove', function(event) {
			    event.preventDefault();
			    endCoords = event.originalEvent.targetTouches[0];
			    $('[id^=highslide-wrapper]').css({top: (endCoords.pageY-startCoords.pageY+tmpY), left: (endCoords.pageX-startCoords.pageX+tmpX)});
			    $('table').eq(0).css({top: (endCoords.pageY-startCoords.pageY+tmpY-10), left: (endCoords.pageX-startCoords.pageX+tmpX-10)});
			    rectmpX = endCoords.pageX-startCoords.pageX+tmpX;
			    rectmpY = endCoords.pageY-startCoords.pageY+tmpY;
			});

			$('[id^=highslide-wrapper]').bind('touchend', function(event) {	
				tmpX=rectmpX;
				tmpY=rectmpY;
			});
			}catch(e){

			}
		}

		const myTimeout = setTimeout(LoadImage, 1000);
		return hs.expand(this);">
			<image src="page/penjualan/grafik/BarGraph.php" width=160 height=160 id="imageku">
		</a>
	</div>
</div>