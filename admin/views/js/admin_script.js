function saveImage(name, block) {
    html2canvas(block, {
        onrendered: function(canvas) {
            theCanvas = canvas;
            var forCanvas = $('.forCanvas');
            forCanvas.append(canvas);

            // Convert and download as image
            // Canvas2Image.saveAsPNG(canvas);

            canvas.toBlob(function(blob) {
                saveAs(blob, name+".png");
            });

            // Clean up
            forCanvas.empty();
        }
    });


    return false;
}

/***** DOCUMENT READY *******/
$(function(){

    var BaseURL = 'http://art-vitalis.com.ua/test/vizitki/admin/';


    /********* SAVE IMAGE ***********/
    $('.saveImage').on('click', function(e){
        e.preventDefault();
        var name = $(this).data('name');
        var block = $(this).parent().prev();
        saveImage(name, block);
    });
    /********* SAVE IMAGE ***********/
    $('.saveLayout').on('click', function(e){
        e.preventDefault();
        var name = $(this).data('name');
        var block = $(this).prev();
        saveImage(name, block);
    });

    /********* DELETE ORDER FROM LIST ***********/
    var del_window = $('#delete_order_window');
    var close_del_window = $('#close, #no');
    var del_order_from_list = $('#del_order');
    var open_del_window = $('.delete_order, #delete_order');
    var order_id;
    open_del_window.on('click', function(e){
        e.preventDefault();
        order_id = $(this).data('order');
        del_window.find('strong').text('№'+order_id);
        del_window.show(500);
    });
    close_del_window.on('click', function(e){
        e.preventDefault();
        del_window.hide(500);
    });
    del_order_from_list.on('click', function(){
        $.ajax({
            url: BaseURL,
            type: 'POST',
            data: {
                del_order_id: order_id
            },
            success: function(result){
                if($.trim(result) == 'OK'){
                    $('#order-'+order_id).remove();
                    del_window.fadeOut(300);
                }
            }

        });
    });

    /********* DELETE SERVICE|GROUP FROM LIST ***********/
    var del_group_window = $('#delete_group_window');
    var open_del_group_window = $('.delete_group');
    var del_group_from_list = $('#del_group');
    var group_id;
    open_del_group_window.on('click', function(e){
        e.preventDefault();
        group_id = $(this).data('group');
        del_group_window.find('strong').text($(this).parent().parent().parent().find('td:first').text());
        del_group_window.show(500);
    });
    close_del_window.on('click', function(e){
        e.preventDefault();
        del_group_window.hide(500);
    });
    del_group_from_list.on('click', function(){
        $.ajax({
            url: BaseURL,
            type: 'POST',
            data: {
                del_group_id: group_id
            },
            success: function(result){
                if($.trim(result) == 'OK'){
                    $('#group-'+group_id).remove();
                    del_group_window.fadeOut(300);
                }
            }

        });
    });



}); // END READY