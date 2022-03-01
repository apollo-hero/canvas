<!doctype html>
  
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My PDF Viewer</title>
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js">
  </script>
</head>
<body>
     <div id="my_pdf_viewer">
        <div id="canvas_container">
            <canvas id="pdf_renderer"></canvas>
        </div>
    </div>
 
    <script>
        var myState = {
            pdf: null,
            currentPage: 1,
            zoom: 1
        }

        var x1,y2,x2,y1,int = 0;
      
        pdfjsLib.getDocument('./1.pdf').then((pdf) => {
      
            myState.pdf = pdf;
            render();
 
        });
 
        function render() {
            myState.pdf.getPage(myState.currentPage).then((page) => {
          
                var canvas = document.getElementById("pdf_renderer");
                var ctx = canvas.getContext('2d');
      
                var viewport = page.getViewport(myState.zoom);
 
                canvas.width = viewport.width;
                canvas.height = viewport.height;
          
                page.render({
                    canvasContext: ctx,
                    viewport: viewport
                });
            });
        }
        function printMousePos(event) {
            int ++;
            if (int % 2 == 0) {
                window.x2 = event.clientX;
                window.y2 = event.clientY;
                draw(window.x1,window.x2,window.y1,window.y2);

                var distance = Math.sqrt((window.x1-window.x2)*(window.x1-window.x2) + (window.y1-window.y2)*(window.y1-window.y2));
                distance = distance/41*0.2;
                context.fillStyle = "blue";
                context.font = "bold 16px Arial";
                context.fillText(distance, (window.x1 + window.x2-16)/2, (window.y1 + window.y2-16)/2);
                alert("distance:" + distance);
            } else {
                // const canvas = document.getElementById('pdf_renderer');
                // const context = canvas.getContext('2d');
                // context.clearRect(0, 0, canvas.width, canvas.height);
                // context.restore();

                window.x1 = event.clientX;
                window.y1 = event.clientY;            
            }
        }

        function draw(x1,x2,y1,y2) {
            const canvas = document.getElementById('pdf_renderer');

            if (!canvas.getContext) {
                return;
            }
            const ctx = canvas.getContext('2d');

            // set line stroke and line width
            ctx.strokeStyle = 'red';
            ctx.lineWidth = 1;

            // draw a red line
            ctx.beginPath();
            ctx.moveTo(x1-8, y1+window.scrollY-8);
            ctx.lineTo(x2-8, y2+window.scrollY-8);
            ctx.stroke();

        }

        document.addEventListener("click", printMousePos);
    </script>
</body>
</html>