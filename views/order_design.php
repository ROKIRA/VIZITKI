<?php defined('VIZITKI') or die('Access denied'); ?>

<?php if(getSession('error')): ?>
    <script type="text/javascript">$(document).ready(function(){
            alert('<?=getSession('error')?>');
        });
        window.location.href = "<?=PATH?>";
    </script>

<?php else: ?>

<section class="upload_layout">
    <h2>Закажите дизайн &laquo;<?=$title?>&raquo;</h2>

    <?php if(getSession('errors')): ?>
        <div class="errors">
            <ul>
                <?=getSession('errors')?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="form_style" method="post" action="<?=PATH?>/offer/order-design" enctype='multipart/form-data'>

       <!-- <label for="upload_images">Загрузить макеты</label>
        <input type="file" name="images[]" id="upload_images" />-->

        <div class="row">
            <label for="wishes" class="label">Пожелания к макету</label>
            <div class="controls">
                <textarea id="wishes" name="wishes"></textarea>
                <div class="help">Введите ваши пожелания к макету</div>
            </div>
        </div>

        <input type="hidden" value="<?=$title?>" name="type" />

        <p class="properties-order">Свойства заказа</p>

        <div class="row">
            <label class="label">Тираж</label>
            <div class="controls">
                <select data-error="" id="printingType" class="valid" name="printing_type">
                    <option data-cost="0"></option>
                    <?php foreach($tiraj as $t): ?>
                        <option data-cost="<?=$t['price']*KURS?>" data-side="<?=$t['type_side']?>" value="<?=$t['id']?>">
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

        <?php if($extra): ?>
            <?php foreach($extra as $ext): ?>
            <div class="row checkbox-style">
                <div class="controls">
                    <input type="checkbox" id="extra-<?=$ext['id']?>" class="extraCost" data-cost1="<?= $ext['price1']*KURS ?>" data-cost2="<?= $ext['price2']*KURS ?>" name="EXTRA[<?=$ext['name']?>]" value="<?=$ext['id']?>" />
                    <label class="simple-label" for="extra-<?=$ext['id']?>"><?=$ext['title']?><span>(+0 грн. за комплект)</span></label>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

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
                            <input type="radio" name="paper_type" id="paperNum-<?=$paper['id']?>" data-cost1="<?=$paper['price1']*KURS ?>" data-cost2="<?=$paper['price2']*KURS ?>" value="<?=$paper['id']?>">
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
        <input type="hidden" id="type_side" name="TMPL[type_side]" value="1"/>

        <div class="row">
            <label class="label"></label>
            <div class="controls">
                <input type="submit" class="but submit" value="Оформить заказ" />
            </div>
        </div>
    </form>

</section>

<?php endif; ?>