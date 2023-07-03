// Sample using dynamic pages with turn.js
var numberOfPages=2;
var loopzoom=0;
var history = 1;
showHint(history);

// Fungsi menambah page increasement page
function addPage(page, magazine) {
// 	First check if the page is already in the book
if (!magazine.turn('hasPage', page)) {
	// Create an element for this page
	var element = $('<div />', {'class': 'page '+((page%2==0) ? 'odd' : 'even'), 'id': 'page-'+page}).html('<i class="loader"></i>');
	// If not then add the page
	magazine.turn('addPage', element, page);
	// Let's assum that the data is comming from the server and the request takes 1s.
	setTimeout(function(){
		/*if(history >= 10){
			alert('jumlah halaman anda max 10');
			window.location = 'OpenBook.php';
		}
		else{*/
			element.html('<div id="boxmagazine" class="data"><canvas id="the-canvas'+page+'" style="width:288px;height:376px;background-color:white;"></div>');
			tuangcanvas(document.getElementById('the-canvas'+page),page,url);	
			history++;			
			showHint(history);		
		//}	
		
		}, 1000);
	}
}

//Deklarasi Awal Animasi Turn Js Magazine

$(window).ready(function() {
	$('#magazine').turn({
		pages: numberOfPages,
		display: 'double',
		acceleration: true,
		gradients: !$.isTouch,
		elevation:50,
			when: {
				turning: function(e, page, view) {

					// Gets the range of pages that the book needs right now
					var range = $(this).turn('range', page);

					// Check if each page is within the book
					for (page = range[0]; page<=range[1]; page++) 
						addPage(page, $(this));

					},

					turned: function(e, page) {
						$('#page-number').val(page);
						$('#number-page').html($('#magazine').turn('page'));

					}
			}
		});
	$('#number-page').html(1);
					

	$('#page-number1').keydown(function(e){

		if (e.keyCode==13){
			$('#magazine').turn('page', $('#page-number1').val());	
			$('#number-page').html($('#magazine').turn('page'));
		}
				
	});

});

//Print Button

function popitup(url) {
	newwindow=window.open(url,'name','height=200,width=150');
	if (window.focus) {newwindow.focus()}
	return false;
}	

//Next Button

function goNext() {
	$('#magazine').turn('next');
	$('#number-page').html($('#magazine').turn('page'));
}	

//Prev Button

function goPrev() {
	$('#magazine').turn('previous');
	$('#number-page').html($('#magazine').turn('page'));
}	
	
//Zoom In

function ZoomIns() {
	loopzoom++;
	if(loopzoom == 1){
		$('#magazine').turn('size',576*(1+(0.25*loopzoom)),376*(1+(0.25*loopzoom)));
		$('#magazine').css('width',576*(1+(0.25*loopzoom)));
		$('#magazine').css('height',376*(1+(0.25*loopzoom)));
		for(i=1;i<=$('#magazine').turn('pages');i++){
			$('#the-canvas'+i).css('width',288*(1+(0.25*loopzoom)));
			$('#the-canvas'+i).css('height',376*(1+(0.25*loopzoom)));
		}
	}
	else if(loopzoom == 2){
		$('#magazine').turn('size',576*(1+(0.25*loopzoom)),376*(1+(0.25*loopzoom)));
		$('#magazine').css('width',576*(1+(0.25*loopzoom)));
		$('#magazine').css('height',376*(1+(0.25*loopzoom)));
		for(i=1;i<=$('#magazine').turn('pages');i++){
			$('#the-canvas'+i).css('width',288*(1+(0.25*loopzoom)));
			$('#the-canvas'+i).css('height',376*(1+(0.25*loopzoom)));
		}
	}
	else if(loopzoom == 3){
		$('#magazine').turn('size',576*(1+(0.25*loopzoom)),376*(1+(0.25*loopzoom)));
		$('#magazine').css('width',576*(1+(0.25*loopzoom)));
		$('#magazine').css('height',376*(1+(0.25*loopzoom)));
		for(i=1;i<=$('#magazine').turn('pages');i++){
			$('#the-canvas'+i).css('width',288*(1+(0.25*loopzoom)));
			$('#the-canvas'+i).css('height',376*(1+(0.25*loopzoom)));
		}
	}
	else if(loopzoom == 4){
		$('#magazine').turn('size',576*(1+(0.25*loopzoom)),376*(1+(0.25*loopzoom)));
		$('#magazine').css('width',576*(1+(0.25*loopzoom)));
		$('#magazine').css('height',376*(1+(0.25*loopzoom)));
		for(i=1;i<=$('#magazine').turn('pages');i++){
			$('#the-canvas'+i).css('width',288*(1+(0.25*loopzoom)));
			$('#the-canvas'+i).css('height',376*(1+(0.25*loopzoom)));
		}
	}
	else if(loopzoom == 5){
		loopzoom = 3;
	}
}		
//Zoom Out

function ZoomOuts() {
	loopzoom--;
	if(loopzoom < 1){
		loopzoom = 5;
	}
	else if(loopzoom == 1){
		$('#magazine').turn('size',576*(1+(0.25*loopzoom)),376*(1+(0.25*loopzoom)));
		$('#magazine').css('width',576*(1+(0.25*loopzoom)));
		$('#magazine').css('height',376*(1+(0.25*loopzoom)));
		for(i=1;i<=$('#magazine').turn('pages');i++){
			$('#the-canvas'+i).css('width',288*(1+(0.25*loopzoom)));
			$('#the-canvas'+i).css('height',376*(1+(0.25*loopzoom)));
		}
	}
	else if(loopzoom == 2){
		$('#magazine').turn('size',576*(1+(0.25*loopzoom)),376*(1+(0.25*loopzoom)));
		$('#magazine').css('width',576*(1+(0.25*loopzoom)));
		$('#magazine').css('height',376*(1+(0.25*loopzoom)));
		for(i=1;i<=$('#magazine').turn('pages');i++){
			$('#the-canvas'+i).css('width',288*(1+(0.25*loopzoom)));
			$('#the-canvas'+i).css('height',376*(1+(0.25*loopzoom)));
		}
	}
	else if(loopzoom == 3){
		$('#magazine').turn('size',576*(1+(0.25*loopzoom)),376*(1+(0.25*loopzoom)));
		$('#magazine').css('width',576*(1+(0.25*loopzoom)));
		$('#magazine').css('height',376*(1+(0.25*loopzoom)));
		for(i=1;i<=$('#magazine').turn('pages');i++){
			$('#the-canvas'+i).css('width',288*(1+(0.25*loopzoom)));
			$('#the-canvas'+i).css('height',376*(1+(0.25*loopzoom)));
		}
	}
	else if(loopzoom == 4){
		$('#magazine').turn('size',576*(1+(0.25*loopzoom)),376*(1+(0.25*loopzoom)));
		$('#magazine').css('width',576*(1+(0.25*loopzoom)));
		$('#magazine').css('height',376*(1+(0.25*loopzoom)));
		for(i=1;i<=$('#magazine').turn('pages');i++){
			$('#the-canvas'+i).css('width',288*(1+(0.25*loopzoom)));
			$('#the-canvas'+i).css('height',376*(1+(0.25*loopzoom)));
		}
	}
	if(loopzoom == 5){
		$('#magazine').turn('size',576,376);
		$('#magazine').css('width',576);
		$('#magazine').css('height',376);
		for(i=1;i<=$('#magazine').turn('pages');i++){
			$('#the-canvas'+i).css('width',288);
			$('#the-canvas'+i).css('height',376);
		}		
		loopzoom = 0;
	}
}		

//Klik keyboard kanan kiri event geser buku kanan kiri

$(window).bind('keydown', function(e){
		
	if (e.keyCode==37)
		$('#magazine').turn('previous');
	else if (e.keyCode==39)
		$('#magazine').turn('next');

	$('#number-page').html($('#magazine').turn('page'));
});
			
