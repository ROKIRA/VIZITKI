$(document).ready(function() {

    var MyBaseURL = 'http://art-vitalis.com.ua/test/vizitki/';

    var confirmTemplate = $('#confirm-template');

    var loadingEditor = $('#loading-editor');

    var current_side = $('#current_side');
    var front_side = $('#front_side');
    var back_side = $('#back_side');

    var textField = $('#cardEditorField');
    var textControl = $('#textEditControl');
    var mainField = $('#cardMainEditor');

    $('#colorpickerHolder').ColorPicker({
        flat: true,
        color: '#000000',
        onSubmit: function(hsb, hex, rgb) {
            $('#colorSelector div').css('backgroundColor', '#' + hex);
            $('#colorpickerHolder').fadeOut(100);
            var color = tieTxtControl($('#colorpickerHolder'));
            color.css('color', '#' + hex);
            confirmTemplate.prop('checked', false);
        }
    });

    $('#colorSelector').on('click', function() {
        $('#colorpickerHolder').stop(true).fadeIn('slow');
        confirmTemplate.prop('checked', false);
    });

    $('#backgroundColorHolder').ColorPicker({
        flat: true,
        color: '#ffffff',
        onSubmit: function(hsb, hex, rgb) {
            $('#backgroundColorSelector div').css('backgroundColor', '#' + hex);
            $('#backgroundColorHolder').fadeOut(100);
            mainField.css('background', '#' + hex);
        }
    });

    $('#backgroundColorSelector').on('click', function() {
        $('#backgroundColorHolder').stop(true).fadeIn('slow');
        confirmTemplate.prop('checked', false);
    });

    $('.lineControl label').on('mouseup', function() {
        var itm = $(this);
        if (itm.children('input').is(':checked')) {
            textField.removeClass('safety_line');
        } else {
            textField.addClass('safety_line');
        }
    });

    var uid = function() {
        var id = Math.floor(Math.random() * 99999999);
        return id;
    };

    $('#sortableBlock').sortable({
        placeholder: "editorContolBlock_light",
        containment: '.sortableBlock',
        cursor: "crosshair",
        distance: 10,
        handle: ".hendl",
        stop: function(event, ui) {
            $('#sortableBlock').children('li').each(function() {
                if ($(this).data('img')) {
                    var sortImg = tieImgSort($(this));
                    sortImg.prependTo(mainField);
                } else {
                    var sortTxt = tieTxtSort($(this));
                    sortTxt.prependTo(textField);
                }
            });
        }
    });

    var tieImgSort = function(target) {
        var itmImg = target.attr('data-id'),
            secImg = mainField.find('[data-id="' + itmImg + '"]');
        return secImg;
    };

    var tieTxtSort = function(target) {
        var itmTxt = target.attr('data-id'),
            secTxt = textField.find('[data-id="' + itmTxt + '"]');
        return secTxt;
    };

    var tieTxt = function(target) {
        var itmp = target.closest('.editorContolBlock'),
            itmp_att = itmp.attr('data-id'),
            txtB = mainField.find('[data-id="' + itmp_att + '"]');
        return txtB;
    };

    var tieTxtControl = function(target) {
        var itmp = target.closest(textControl),
            itmp_att = itmp.attr('data-id'),
            txtB = textField.find('[data-id="' + itmp_att + '"]');
        return txtB;
    };

    var tieTxtBack = function(target) {
        var itmp_att = target.attr('data-id'),
            txtB = $('#sortableBlock').find('[data-id="' + itmp_att + '"]');
        return txtB;
    };

    var addTxt = function() {
        var id = uid();
        var li = $('<li>').addClass('editorContolBlock').attr('data-id', id),
            vis = $('<div>').addClass('visible'),
            hen = $('<div>').addClass('hendl'),
            del = $('<div>').addClass('delBtn'),
            inp = $('<input type="text" value="New text">');
        vis.appendTo(li);
        hen.appendTo(li);
        del.appendTo(li);
        inp.appendTo(li);
        li.prependTo('#sortableBlock');

        var txtm = $('<div>').addClass('txtMove').attr('data-id', id).text('New text');
        txtm.appendTo(textField);

        $('.txtMove').draggable({
            containment: "parent"
        });
        inp.focus();
    };

    var addImage = function() {
        var id = uid();
        var last_name = $('#new_photo').text();
        var li = $('<li>').addClass('editorContolBlock').attr('data-id', id).attr('data-name',last_name).data('img', true),
            vis = $('<div>').addClass('visible'),
            hen = $('<div>').addClass('hendl'),
            del = $('<div>').addClass('delBtn'),
            imgC = $('<div>').addClass('imgControl'),
            imgP = $('<div>').addClass('imgPreview');

        img = $('<img src="'+MyBaseURL+'uploads/_temp/'+last_name+'">');
        img.appendTo(imgP);
        imgP.appendTo(imgC);
        imgC.appendTo(li);
        vis.appendTo(li);
        hen.appendTo(li);
        del.appendTo(li);
        li.prependTo('#sortableBlock');

        var imgCont = $('<div>').addClass('imgMove').attr('data-id', id);
        var imgm = $('<img src="'+MyBaseURL+'uploads/_temp/'+last_name+'" alt="">');
        imgm.appendTo(imgCont);
        imgCont.appendTo(mainField);

        $('.imgMove').draggable().resizable();

        confirmTemplate.prop('checked', false);
    };

    $(document).on('keydown', function(e) {
        if (e.keyCode == 16) {
            textField.addClass('point');
        }
        confirmTemplate.prop('checked', false);
    }).on('keyup', function(e) {
        if (e.keyCode == 16) {
            textField.removeClass('point');
        }
        confirmTemplate.prop('checked', false);
    });

    $(document).on('click','.delBtn', function() {
        var del = $(this).parent('.editorContolBlock'),
            txtB = tieTxt($(this));
        del.addClass('lightSpeedOut');
        txtB.css({
            '-webkit-transform': 'scale(0.1)',
            '-moz-transform': 'scale(0.1)',
            '-ms-transform': 'scale(0.1)',
            '-o-transform': 'scale(0.1)',
            'transform': 'scale(0.1)'
        });
        $('<div class="disbl"></div>').appendTo(del);
        setTimeout(function() {
            del.remove();
            txtB.remove();
        }, 300);
        confirmTemplate.prop('checked', false);
    });

    $(document).on('click','.visible', function() {
        var vis = $(this).parent('.editorContolBlock'),
            itm = $(this),
            txtB = tieTxt(itm);
        if (itm.data('visi')) {
            itm.data('visi', false);
            vis.css('opacity', 1);
            vis.children('.disbl').remove();
            txtB.removeClass('hidden');
        } else {
            itm.data('visi', true);
            vis.css('opacity', 0.2);
            $('<div class="disbl"></div>').appendTo(vis);
            txtB.addClass('hidden');
        }
        confirmTemplate.prop('checked', false);
    });

    $('#addText').on('click touchstart', function(event) {
        event.preventDefault();
        addTxt();
        confirmTemplate.prop('checked', false);
    });

    $('.addimageBlock .editorBtn').on('click touchstart', function(event) {
        $(this).parent().children('.addImageField').fadeIn(300);
        confirmTemplate.prop('checked', false);
    });


    $('#addImage').on('click touchstart', function(event) {
        $(this).parent().parent().fadeOut(20);
        confirmTemplate.prop('checked', false);
    });


    $('#superframe').on('load',function(){
        if($('#new_photo').text()!=''){addImage();}
        confirmTemplate.prop('checked', false);
    });

    var setTxtParam = function(target, child) {
        textControl.children(child).find('option').prop('selected', false);
        textControl.children(child).find("option[value='" + target + "']").prop("selected", true);
        console.log(target);
        confirmTemplate.prop('checked', false);
    };

    var setTxtStyle = function(styleBtn, bool) {
        if (bool) {
            $(styleBtn).addClass('active');
        } else {
            $(styleBtn).removeClass('active');
        }
        confirmTemplate.prop('checked', false);
    };

    $(document).on('focus','.editorContolBlock input', function(event) {
        textField.removeClass('point');
        var focItm = tieTxt($(this)),
            fAtt = focItm.attr('data-id');
        focItm.addClass('edit');
        textControl.attr('data-id', fAtt).fadeIn(100);
        setTxtParam(focItm.css('font-family').replace(new RegExp("'", 'g'),''), '.chooseFont');
        setTxtParam(parseInt(focItm.css('font-size'), 10), '.chooseFontSize');
        $('#colorSelector div').css('background-color', focItm.css('color'));
        $('#colorpickerHolder').ColorPickerSetColor(focItm.css('color'));
        setTxtStyle('#txtBold', focItm.css('font-weight') === 'bold');
        setTxtStyle('#txtItalic', focItm.css('font-style') === 'italic');
        setTxtStyle('#txtUnder', focItm.css('text-decoration').split(" ")[0] === 'underline');

        confirmTemplate.prop('checked', false);
    });

    $(document).on('blur','.editorContolBlock input', function(event) {
        var focItm = tieTxt($(this));
        focItm.removeClass('edit');
        confirmTemplate.prop('checked', false);
    });

    $(document).on('keyup','.editorContolBlock input', function(event) {
        var focItm = tieTxt($(this));
        focItm.text($(this).val());
        confirmTemplate.prop('checked', false);
    });

    $(document).on('mouseenter','.txtMove', function() {
        var inp = tieTxtBack($(this));
        inp.children('input').addClass('edit');
    });

    $(document).on('dblclick','.txtMove', function() {
        var inp = tieTxtBack($(this));
        inp.children('input').focus();
        confirmTemplate.prop('checked', false);
    });

    $(document).on('mouseout','.txtMove', function(event) {
        var inp = tieTxtBack($(this));
        inp.children('input').removeClass('edit');
        confirmTemplate.prop('checked', false);
    });

    $(document).on('change','.chooseFont select', function() {
        var val = $(this).val().replace(new RegExp("'", 'g'),'');
        txtid = textControl.attr('data-id');
        textField.find('[data-id="' + txtid + '"]').css({
            'font-family': val
        });
        confirmTemplate.prop('checked', false);
    });

    $(document).on('change','.chooseFontSize select', function() {
        var val = $(this).val();
        txtid = textControl.attr('data-id');
        textField.find('[data-id="' + txtid + '"]').css({
            'font-size': val + 'px'
        });
        confirmTemplate.prop('checked', false);
    });

    $(document).on('click','#txtBold', function(event) {
        event.preventDefault();
        var th = $(this);
        var itm = tieTxtControl(th);
        if (th.hasClass('active')) {
            itm.css('font-weight', 'normal');
            th.removeClass('active');
        } else {
            itm.css('font-weight', 'bold');
            th.addClass('active');
        }
        confirmTemplate.prop('checked', false);
    });

    $(document).on('click','#txtItalic', function(event) {
        event.preventDefault();
        var th = $(this);
        var itm = tieTxtControl(th);
        if (th.hasClass('active')) {
            itm.css('font-style', 'normal');
            th.removeClass('active');
        } else {
            itm.css('font-style', 'italic');
            th.addClass('active');
        }
        confirmTemplate.prop('checked', false);
    });

    $(document).on('click','#txtUnder', function(event) {
        event.preventDefault();
        var th = $(this);
        var itm = tieTxtControl(th);
        if (th.hasClass('active')) {
            itm.css('text-decoration', 'none');
            th.removeClass('active');
        } else {
            itm.css('text-decoration', 'underline');
            th.addClass('active');
        }
        confirmTemplate.prop('checked', false);
    });

    /*--------------------------  SAVE TEMPLATE  ------------------------------------ */

    function saveTemplate(side){
        doImage(side);

        var str = '';
        var itm = $('#sortableBlock li');
        var itmlen = itm.length;

        itm.each(function(i) {
            var liInWin = tieTxtSort($(this));
            var liImgWin = tieImgSort($(this));
            var liNew = {};
            liNew.data_id = $(this).attr('data-id');
            liNew.data_name = $(this).attr('data-name');
            liNew.data_type = $(this).data('img');
            liNew.data_vis = $(this).children('.visible').data('visi');
            liNew.data_value = $(this).children('input').val();
            liNew.style = liInWin.attr('style');
            liNew.styleImg = liImgWin.attr('style');
            str += JSON.stringify(liNew)+'|||';
        });
        var liCol = itmlen;
        str += JSON.stringify(liCol)+'|||';
        var color = $('#backgroundColorSelector div').css('background-color');
        str += JSON.stringify(color);
        if(side == 1)
            $('#code_template').val(str);
        else
            $('#code_template1').val(str);
    }


    $(document).on('click', '#confirm-template', function(){
        saveTemplate(current_side.val());
    });
    /*function(){
        //if(!this.checked()) return false;

        doImage(1);

        var str = '';
        var itm = $('#sortableBlock li');
        var itmlen = itm.length;

        itm.each(function(i) {
            var liInWin = tieTxtSort($(this));
            var liImgWin = tieImgSort($(this));
            var liNew = {};
            liNew.data_id = $(this).attr('data-id');
            liNew.data_name = $(this).attr('data-name');
            liNew.data_type = $(this).data('img');
            liNew.data_vis = $(this).children('.visible').data('visi');
            liNew.data_value = $(this).children('input').val();
            liNew.style = liInWin.attr('style');
            liNew.styleImg = liImgWin.attr('style');
            str += JSON.stringify(liNew)+'|||';
        });
        var liCol = itmlen;
        str += JSON.stringify(liCol)+'|||';
        var color = $('#backgroundColorSelector div').css('background-color');
        str += JSON.stringify(color);
        $('#code_template').val(str);
    });*/


   /* $(document).on('click','#save', function(event) {
        event.preventDefault();
        doImage(1);

        var str = '';
        var itm = $('#sortableBlock li');
        var itmlen = itm.length;

        itm.each(function(i) {
            var liInWin = tieTxtSort($(this));
            var liImgWin = tieImgSort($(this));
            var liNew = {};
            liNew.data_id = $(this).attr('data-id');
            liNew.data_name = $(this).attr('data-name');
            liNew.data_type = $(this).data('img');
            liNew.data_vis = $(this).children('.visible').data('visi');
            liNew.data_value = $(this).children('input').val();
            liNew.style = liInWin.attr('style');
            liNew.styleImg = liImgWin.attr('style');
            str += JSON.stringify(liNew)+'|||';
        });
        var liCol = itmlen;
        str += JSON.stringify(liCol)+'|||';
        var color = $('#backgroundColorSelector div').css('background-color');
        str += JSON.stringify(color);
        $('#code_template').val(str);
    });

    $(document).on('click','#save1', function(event) {
        event.preventDefault();
        doImage(2);

        var str = '';
        var itm = $('#sortableBlock li');
        var itmlen = itm.length;

        itm.each(function(i) {
            var liInWin = tieTxtSort($(this));
            var liImgWin = tieImgSort($(this));
            var liNew = {};
            liNew.data_id = $(this).attr('data-id');
            liNew.data_name = $(this).attr('data-name');
            liNew.data_type = $(this).data('img');
            liNew.data_vis = $(this).children('.visible').data('visi');
            liNew.data_value = $(this).children('input').val();
            liNew.style = liInWin.attr('style');
            liNew.styleImg = liImgWin.attr('style');
            str += JSON.stringify(liNew)+'|||';
        });
        var liCol = itmlen;
        str += JSON.stringify(liCol)+'|||';
        var color = $('#backgroundColorSelector div').css('background-color');
        str += JSON.stringify(color);
        $('#code_template1').val(str);
    });*/
    /*-----------------------------------------INIT------------------------------*/

    if($('.init_template').length){
        var str = $('#code_template').val().split('|||');
        var liC = JSON.parse(str[str.length-2]);
        var color = JSON.parse(str[str.length-1]);

        $('#backgroundColorSelector div').css('background-color', color);
        mainField.css('background-color', color);
        if (liC > 0) {
            for (var c = 0; c < liC; c++) {
                var liItm = JSON.parse(str[c]);
                if (liItm.data_type === true) {
                    var liImg = $('<li>').addClass('editorContolBlock').attr('data-id', liItm.data_id).attr('data-name', liItm.data_name).data('img', true),
                        visImg = $('<div>').addClass('visible'),
                        henImg = $('<div>').addClass('hendl'),
                        delImg = $('<div>').addClass('delBtn'),
                        imgC = $('<div>').addClass('imgControl'),
                        imgP = $('<div>').addClass('imgPreview');
                    if (liItm.data_vis === true) {
                        visImg.data('visi', true);
                        li.css('opacity', 0.2);
                    }

                    img = $('<img src="'+MyBaseURL+'uploads/templates/'+liItm.data_name+'">');
                    img.appendTo(imgP);
                    imgP.appendTo(imgC);
                    imgC.appendTo(liImg);
                    visImg.appendTo(liImg);
                    henImg.appendTo(liImg);
                    delImg.appendTo(liImg);
                    liImg.appendTo('#sortableBlock');

                    var imgCont = $('<div>').addClass('imgMove').attr('style', liItm.styleImg).attr('data-id', liItm.data_id);
                    var imgm = $('<img src="'+MyBaseURL+'uploads/templates/'+liItm.data_name+'" alt="">');
                    imgm.appendTo(imgCont);
                    imgCont.appendTo(mainField);

                    $('.imgMove').draggable().resizable();

                } else {
                    var li = $('<li>').addClass('editorContolBlock').attr('data-id', liItm.data_id),
                        vis = $('<div>').addClass('visible'),
                        hen = $('<div>').addClass('hendl'),
                        del = $('<div>').addClass('delBtn'),
                        inp = $('<input type="text" value="' + liItm.data_value + '">');
                    if (liItm.data_vis === true) {
                        vis.data('visi', true);
                        li.css('opacity', 0.2);
                    }
                    vis.appendTo(li);
                    hen.appendTo(li);
                    del.appendTo(li);
                    inp.appendTo(li);
                    li.appendTo('#sortableBlock');

                    var txtm = $('<div>').addClass('txtMove').attr('style', liItm.style).attr('data-id', liItm.data_id).text(liItm.data_value);
                    txtm.prependTo(textField);
                    $('.txtMove').draggable({
                        containment: "parent"
                    });
                }
            }
        }

        setTimeout(function(){
            loadingEditor.hide();
        },2500);
    }

    function changeSideToFront(){
           back_side.removeClass('active');
            //$('#save1').attr('id','save');
            $('.delBtn').trigger('click');
            front_side.addClass('active');
            current_side.val(1);
            var str = $('#code_template').val().split('|||');
            var liC = JSON.parse(str[str.length-2]);
            var color = JSON.parse(str[str.length-1]);

            $('#backgroundColorSelector div').css('background-color', color);
            mainField.css('background-color', color);
            if (liC > 0) {
                for (var c = 0; c < liC; c++) {
                    var liItm = JSON.parse(str[c]);
                    if (liItm.data_type === true) {
                        var liImg = $('<li>').addClass('editorContolBlock').attr('data-id', liItm.data_id).attr('data-name', liItm.data_name).data('img', true),
                            visImg = $('<div>').addClass('visible'),
                            henImg = $('<div>').addClass('hendl'),
                            delImg = $('<div>').addClass('delBtn'),
                            imgC = $('<div>').addClass('imgControl'),
                            imgP = $('<div>').addClass('imgPreview');
                        if (liItm.data_vis === true) {
                            visImg.data('visi', true);
                            li.css('opacity', 0.2);
                        }

                        img = $('<img src="'+MyBaseURL+'/uploads/templates/'+liItm.data_name+'">');
                        img.appendTo(imgP);
                        imgP.appendTo(imgC);
                        imgC.appendTo(liImg);
                        visImg.appendTo(liImg);
                        henImg.appendTo(liImg);
                        delImg.appendTo(liImg);
                        liImg.appendTo('#sortableBlock');

                        var imgCont = $('<div>').addClass('imgMove').attr('style', liItm.styleImg).attr('data-id', liItm.data_id);
                        var imgm = $('<img src="'+MyBaseURL+'uploads/templates/'+liItm.data_name+'" alt="">');
                        imgm.appendTo(imgCont);
                        imgCont.appendTo(mainField);

                        $('.imgMove').draggable().resizable();

                    } else {
                        var li = $('<li>').addClass('editorContolBlock').attr('data-id', liItm.data_id),
                            vis = $('<div>').addClass('visible'),
                            hen = $('<div>').addClass('hendl'),
                            del = $('<div>').addClass('delBtn'),
                            inp = $('<input type="text" value="' + liItm.data_value + '">');
                        if (liItm.data_vis === true) {
                            vis.data('visi', true);
                            li.css('opacity', 0.2);
                        }
                        vis.appendTo(li);
                        hen.appendTo(li);
                        del.appendTo(li);
                        inp.appendTo(li);
                        li.appendTo('#sortableBlock');

                        var txtm = $('<div>').addClass('txtMove').attr('style', liItm.style).attr('data-id', liItm.data_id).text(liItm.data_value);
                        txtm.prependTo(textField);
                        $('.txtMove').draggable({
                            containment: "parent"
                        });
                    }
                }
            }
    }


    function changeSideToBack(){
            front_side.removeClass('active');
            //$('#save').attr('id','save1');
            $('.delBtn').trigger('click');
            back_side.addClass('active');
            current_side.val(2);
            var str = $('#code_template1').val().split('|||');
            var liC = JSON.parse(str[str.length-2]);
            var color = JSON.parse(str[str.length-1]);

            $('#backgroundColorSelector div').css('background-color', color);
            mainField.css('background-color', color);
            if (liC > 0) {
                for (var c = 0; c < liC; c++) {
                    var liItm = JSON.parse(str[c]);
                    if (liItm.data_type === true) {
                        var liImg = $('<li>').addClass('editorContolBlock').attr('data-id', liItm.data_id).attr('data-name', liItm.data_name).data('img', true),
                            visImg = $('<div>').addClass('visible'),
                            henImg = $('<div>').addClass('hendl'),
                            delImg = $('<div>').addClass('delBtn'),
                            imgC = $('<div>').addClass('imgControl'),
                            imgP = $('<div>').addClass('imgPreview');
                        if (liItm.data_vis === true) {
                            visImg.data('visi', true);
                            li.css('opacity', 0.2);
                        }

                        img = $('<img src="'+MyBaseURL+'/uploads/templates/'+liItm.data_name+'">');
                        img.appendTo(imgP);
                        imgP.appendTo(imgC);
                        imgC.appendTo(liImg);
                        visImg.appendTo(liImg);
                        henImg.appendTo(liImg);
                        delImg.appendTo(liImg);
                        liImg.appendTo('#sortableBlock');

                        var imgCont = $('<div>').addClass('imgMove').attr('style', liItm.styleImg).attr('data-id', liItm.data_id);
                        var imgm = $('<img src="'+MyBaseURL+'uploads/templates/'+liItm.data_name+'" alt="">');
                        imgm.appendTo(imgCont);
                        imgCont.appendTo(mainField);

                        $('.imgMove').draggable().resizable();

                    } else {
                        var li = $('<li>').addClass('editorContolBlock').attr('data-id', liItm.data_id),
                            vis = $('<div>').addClass('visible'),
                            hen = $('<div>').addClass('hendl'),
                            del = $('<div>').addClass('delBtn'),
                            inp = $('<input type="text" value="' + liItm.data_value + '">');
                        if (liItm.data_vis === true) {
                            vis.data('visi', true);
                            li.css('opacity', 0.2);
                        }
                        vis.appendTo(li);
                        hen.appendTo(li);
                        del.appendTo(li);
                        inp.appendTo(li);
                        li.appendTo('#sortableBlock');

                        var txtm = $('<div>').addClass('txtMove').attr('style', liItm.style).attr('data-id', liItm.data_id).text(liItm.data_value);
                        txtm.prependTo(textField);
                        $('.txtMove').draggable({
                            containment: "parent"
                        });
                    }
                }
            }
    }


    $(document).on('click','#front_side',function(){
        if(back_side.hasClass('active')) {
            loadingEditor.show();
            saveTemplate(2);
            setTimeout(function () {
                changeSideToFront();
                setTimeout(function () {
                    loadingEditor.hide();
                }, 400);
            }, 800);
        }
        return false;
    });

    $(document).on('click','#back_side',function(){
        if(front_side.hasClass('active')) {
            loadingEditor.show();
            saveTemplate(1);
            setTimeout(function () {
                changeSideToBack();
                setTimeout(function () {
                    loadingEditor.hide();
                }, 400);
            }, 800);
        }
        return false;
    });


/********************************* ADD BACK SIDE AND SAVE CHANGES**********************************************/

// beautiful window with templates
    var add_back_side_btn = $('#add_back_side');
    var layout = $('#add_bside_window_bg');
    var modal_window = $('#add_bside_window');
    var close_window = $('#close_bside_window');
    var window_body = $('#window_body');
    var tpl_alias = add_back_side_btn.data('template-alias');
    var downloadF = true;

    function closeWindow(){
        modal_window.slideUp(500);
        setTimeout(function(){
            layout.fadeOut(500);
        }, 300);
    }

    add_back_side_btn.on('click', function(){
        layout.fadeIn(300);
        setTimeout(function(){
            modal_window.slideDown(400);
            setTimeout(function(){
                if(downloadF){
                    $.ajax({
                        url: '',
                        type: 'POST',
                        data: {
                            add_back_side: true,
                            alias: tpl_alias
                        },
                        success: function(data){
                            window_body.html(data);
                            downloadF = false;
                            window_body.css('backgroundImage','none');
                        }
                    });
                }
            }, 400);
        }, 200);
    });

    close_window.on('click', function(){
        closeWindow();
    });

    layout.on('click', function(e){
        if($(e.target).closest("#add_bside_window").length==0)
            closeWindow();
    });

// download template
    window_body.on('click', 'a[id^=tpl-]', function(e){
        e.preventDefault();

        var _self = $(this);
        var id = _self.data('id');
        var group = _self.data('group');
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                choose_template: true,
                id: id
            },
            success: function(data){
                loadingEditor.show();
                data = JSON.parse(data);
                $('#code_template1').val(data.code_face);
                $('.type_tmpl_block').show();
                $('#type_side').val(2);
                add_back_side_btn.text('Изменить обратную сторону');
                closeWindow();
                saveTemplate(current_side.val());
                setTimeout(function(){
                    if(current_side.val() == 1){
                        current_side.val(2);
                        changeSideToBack();
                    }else{
                        changeSideToFront();
                        $('#code_template1').val(data.code_face);
                        changeSideToBack();
                    }

                    setTimeout(function(){
                        loadingEditor.hide();
                    },2500);
                }, 1000);

            }
        });

    });

/********************************* END ADD BACK SIDE **********************************************/

}); // END READY