<h1>ШАГ 2</h1>
<section class="preview">
    <div id="previews">
        <?php $tpl = getSession('TMPL'); ?>
        <figure class="front">
            <img src="<?=$tpl['img_out_1']?>" alt="preview"/>
        </figure>
            <?php if($tpl['img_out_2'] != NULL): ?>
                <figure class="back">
                    <img src="<?=$tpl['img_out_2']?>" alt="preview 2"/>
                </figure>
            <?php endif; ?>
    </div>
</section>

<?php if($tpl['img_out_2'] != NULL): ?>
    <p><a id="rotate_back" href="#">Обратная сторона</a></p>
<?php endif; ?>
<p><a class="back_to_editor" href="<?=$_SERVER['HTTP_REFERER']?>">Вернуться к редактированию</a></p>

<div class="like_h1">Поля заказа</div>

<form action="<?=PATH?>/offer/order2" method="post">
    <div class="row">
        <label for="wishes" class="label">Пожелания к макету</label>
        <div class="controls">
            <textarea data-error="" id="wishes" name="wishes" class="valid"></textarea>
            <div class="help">Введите ваши пожелания к макету</div>
        </div>
    </div>

    <input type="hidden" value="12" name="group_id" />

    <p class="properties-order">Свойства заказа</p>

    <div class="row">
        <label class="label">Тираж</label>
        <div class="controls">
            <select data-error="" id="printingType" class="valid" name="printing_type">
                <option data-cost="0"></option>
                <?php foreach($tiraj as $t): ?>
                    <option data-cost="<?=ceil($t['price']*KURS)?>" data-side="<?=$t['type_side']?>" value="<?=$t['id']?>">
                        <?=$t['text']?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="help">Выберите тираж</div>
        </div>
    </div>


    <div class="row">
        <label for="printing-number" class="label">Количесто комплектов</label>
        <div class="controls">
            <input id="printing-number" type="text" name="kolvo" value="1" class="valid digits" />
        </div>
    </div>

    <p class="properties-order">Дополнительные услуги</p>

    <div id="showPaperType">
        <p class="properties-order"><span class="small-italic">Тип бумаги</span></p>
        <span><span style="color:red; font-size: 15px;">Выберите тип бумаги</span></span>
        <a href="#" class="but" id="changePaper">Изменить</a>
    </div>


    <div id="paper-list-block">
        <ul id="paper-list-ul">
            <?php foreach($paper_types as $paper): ?>
                <li>
                    <div class="radioSelect">
                        <input type="radio" name="paper_type" id="paperNum-<?=$paper['id']?>" data-cost1="<?=ceil($paper['price1']*KURS)?>" data-cost2="<?=ceil($paper['price2']*KURS)?>" value="<?=$paper['id']?>">
                        <label for="paperNum-<?=$paper['id']?>"><?=$paper['title']?></label>
                    </div>
                    <img src="<?=PATH.'/uploads/paper_type/'.$paper['image']?>"/>
                    <p class="addCost">+0 грн за комплект</p>
                    <div class="infoPaper">
                        <p><span>Плотность:</span> <?=$paper['density']?> гр/м2</p>
                        <p><span>Цвет:</span> <?=$paper['color']?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <p class="properties-order">Авторские права</p>

    <div class="row checkbox-style">
        <div class="controls">
            <input id="confirm-author" type="checkbox" name="confirm_copy_rights" class="valid" />
            <label for="confirm-author" class="simple-label">Оформляя заказ, я подтверждаю, что не нарушаю чьих-либо авторских прав на макет в целом, либо на его составные элементы.</label>
        </div>
    </div>

    <div class="row" style="display: none;">
        <label for="selected_type_paper" class="label">Пожелания к макету</label>
        <div class="controls">
            <input data-error="" id="selected_type_paper" name="selected_type_paper" class="valid" value=""/>
            <div class="help">Выберите тип бумаги</div>
        </div>
    </div>

    <div class="cost-style">
        <span class="noPrinting">Вы не выбрали тираж!</span>
        <br>
        <span>Итого:</span> <span id="totalCost">0</span> грн
    </div>

    <div class="row">
        <label class="label"></label>
        <div class="controls">
            <input type="submit" class="but submit" value="Добавиьт в корзину" />
        </div>
    </div>
</form>


<script type="text/javascript">
    var preview = $('#previews');
    $(document).ready(function(){

        var front = true;
        $('#rotate_back').on('click' ,function(e){
            e.preventDefault();
            if(front){
                preview.addClass('flip');
                $(this).text('Лицевая сторона');
                front = false;
            }
            else{
                preview.removeClass('flip');
                $(this).text('Обратная сторона');
                front = true;
            }
        });

    }); //END READY
</script>