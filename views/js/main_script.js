function doImage(side) {
    html2canvas($("#cardMainEditor"), {
        onrendered: function(canvas) {
            theCanvas = canvas;
            document.body.appendChild(canvas);

            // Convert and download as image
            // Canvas2Image.saveAsPNG(canvas);

            var out = $("#img_out_"+side);

            out.find('canvas').remove();
            out.find('img').remove();
            out.append(canvas);

            /*var tmp = canvas.toDataURL("image/png");

            $.ajax({
                type: 'POST',
                url: '',
                data: {
                    doImage: true,
                    dataImg: tmp
                },
                success: function(result){

                }
            });*/



            out.append(Canvas2Image.convertToPNG(canvas));
            $('#img-out-'+side).val(out.find('img').attr('src'));

            // Clean up
            //document.body.removeChild(canvas);
        }
    });
}



$(document).ready(function(){


/************************** AUTH | LOGIN *********************/
    var authWindow = $('#login');
    var openWindow = $('#auth, #auth_from_basket');
    var closeWindow = $('#close');

    function openAuthWindow(){
        authWindow.fadeIn(400);
    }
    function closeAuthWindow(){
        authWindow.fadeOut(400);
    }

    openWindow.on('click', function(e){
        e.preventDefault();
        openAuthWindow();
    });
    closeWindow.on('click', function(){
        closeAuthWindow();
    });


});// END READY