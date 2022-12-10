<div id="leftBar">
	<p>Bar Graph</p>
	<a href="page/pengeluaran/grafik/BarGraph.php?tglbefore=<?php echo $_SESSION['tglbefore']; ?>&tglafter=<?php echo $_SESSION['tglafter']; ?>" class="highslide" onclick="return hs.expand(this)">
		<image src="page/pengeluaran/grafik/BarGraph.php?tglbefore=<?php echo $_SESSION['tglbefore']; ?>&tglafter=<?php echo $_SESSION['tglafter']; ?>" width=160 height=160>
	</a>
</div>
<div id="midleBar">
	<p>Line Graph</p>
	<a href="page/pengeluaran/grafik/LineGraph.php?tglbefore=<?php echo $_SESSION['tglbefore']; ?>&tglafter=<?php echo $_SESSION['tglafter']; ?>" class="highslide" onclick="return hs.expand(this)">
		<image src="page/pengeluaran/grafik/LineGraph.php?tglbefore=<?php echo $_SESSION['tglbefore']; ?>&tglafter=<?php echo $_SESSION['tglafter']; ?>" class="highslide" width=160 height=160>
	</a>
</div>
<div id="rightBar">
	<p>Pie Graph</p>
	<a href="page/pengeluaran/grafik/PieGraph.php?tglbefore=<?php echo $_SESSION['tglbefore']; ?>&tglafter=<?php echo $_SESSION['tglafter']; ?>" class="highslide" onclick="return hs.expand(this)">
		<image src="page/pengeluaran/grafik/PieGraph.php?tglbefore=<?php echo $_SESSION['tglbefore']; ?>&tglafter=<?php echo $_SESSION['tglafter']; ?>" class="highslide" width=160 height=160>
	</a>
</div>
