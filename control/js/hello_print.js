//
    // NOTE: 
    // Modifying the URL below to another server will likely *NOT* work. Because of browser
    // security restrictions, we have to use a file server with special headers
    // (CORS) - most servers don't support cross-origin browser requests.
    //

    //
    // Disable workers to avoid yet another cross-origin issue (workers need the URL of
    // the script to be loaded, and currently do not allow cross-origin scripts)
    //
    PDFJS.disableWorker = true;
    var pdfDoc = null,
        pageNum = 1,
        scale = 1;
    //
    // Get page info from document, resize canvas accordingly, and render page
    //
    function renderPage(canvas,num) {
      //Declaration ctx
      ctx = canvas.getContext('2d');

      // Using promise to fetch the page
      pdfDoc.getPage(num).then(function(page) {
        var viewport = page.getViewport(scale);
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        // Render PDF page into canvas context
        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
        page.render(renderContext);
	if(num == 10){
		setTimeout(window.print(),10000);
	}
      });

      // Update page counters
    }

    //
    // Go to previous page
    //
    /*function goPrevious() {
      if (pageNum <= 1)
        return;
      pageNum--;
      renderPage(canvas2,pageNum,ctx2);
    }*/

    //
    // Go to next page
    //
    /*function goNext() {
      if (pageNum >= pdfDoc.numPages)
        return;
      pageNum++;
      renderPage(canvas2,pageNum,ctx2);
    }*/
    //
    // Asynchronously download PDF as an ArrayBuffer
    //
    function tuangcanvas(canvas,numb,url){
	    PDFJS.getDocument(url).then(function getPdfHelloWorld(_pdfDoc) {
	      pdfDoc = _pdfDoc;
	      renderPage(canvas,numb);
	    });
    }

    //Menuangkan pdf ke canvas html dengan number pagenya dan halaman urlnya
    //tuangcanvas(document.getElementById('the-canvas'),1,'1.pdf');
    //tuangcanvas(target,pagenum,url);

    for(i=0;i<=11;i++)
	{
		if(i < 11){
			tuangcanvas(document.getElementById('the-canvas'+i),i,url);
		}
		else{	
		}
	}
