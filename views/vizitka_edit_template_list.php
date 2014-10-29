<?php defined('VIZITKI') or die('Access denied'); ?>

<section class="templates">
    <?php require_once 'blocks/bigButtonsMenu.php' ?>

    <section class="templates-wrap">

        <h2>Редактируйте шаблон Визитки</h2>

        <ul id="categories">
            <li class="active"><a href="#" data-category="new">Новинки</a></li>
            <?php foreach($categories as $category): ?>
            <li><a href="#" data-category="<?=$category['alias']?>"><?=$category['name']?></a></li>
            <?php endforeach; ?>
        </ul>

        <section class="tpl">
            <div id="category-new">
                <div class="servicesBlock_group">
                    <a class="servicesInfoTop_group" href="<?=PATH?>/catalog/upload-layout/">
                        <img alt="Загрузите шаблон" src="<?=UPLOADS?>uploadTpl.png"/>
                        <div class="servicesInfo_group">
                            <a href="<?=PATH?>/catalog/upload-layout/" >Загрузить</a>
                        </div><!-- .servicesInfo -->
                    </a><!-- .servicesInfoTop -->
                </div>
                <?php foreach($newTemplates as $tpl): ?>
                    <div class="servicesBlock_group">
                        <a class="servicesInfoTop_group" href="<?=PATH?>/catalog/edit-template-vizitki/<?=$tpl['category']?>/<?=$tpl['id']?>">
                            <img alt="<?=$tpl['name']?>" src="
                                    <?=($tpl['preview'] ? PATH.'/uploads/templates/'.$tpl['preview'] : PATH.'/uploads/no_image.jpg')?>
                                "/>
                            <div class="servicesInfo_group">
                                <div class="like-h5"><?=$tpl['name']?></div>
                                <a href="<?=PATH?>/catalog/edit-template-vizitki/<?=$tpl['category']?>/<?=$tpl['id']?>">Редактировать</a>
                            </div><!-- .servicesInfo -->
                        </a><!-- .servicesInfoTop -->
                    </div>
                <?php endforeach; ?>
            </div>
            <?php foreach($categories as $category): ?>
                <div id="category-<?=$category['alias']?>">
                    <div class="servicesBlock_group">
                        <a class="servicesInfoTop_group" href="<?=PATH?>/catalog/upload-layout/">
                            <img alt="Загрузите шаблон" src="<?=UPLOADS?>uploadTpl.png"/>
                            <div class="servicesInfo_group">
                                <a href="<?=PATH?>/catalog/upload-layout/" >Загрузить</a>
                            </div><!-- .servicesInfo -->
                        </a><!-- .servicesInfoTop -->
                    </div>
                    <?php $i=0; foreach($templates as $tpl): ?>
                        <?php if($category['alias'] == $tpl['category']): ?>
                            <div class="servicesBlock_group">
                                <a class="servicesInfoTop_group" href="<?=PATH?>/catalog/edit-template-vizitki/<?=$tpl['category']?>/<?=$tpl['id']?>">
                                    <img alt="<?=$tpl['name']?>" src="
                                        <?=($tpl['preview'] ? PATH.'/uploads/templates/'.$tpl['preview'] : PATH.'/uploads/no_image.jpg')?>
                                    "/>
                                    <div class="servicesInfo_group">
                                        <div class="like-h5"><?=$tpl['name']?></div>
                                        <a href="<?=PATH?>/catalog/edit-template-vizitki/<?=$tpl['category']?>/<?=$tpl['id']?>">Редактировать</a>
                                    </div><!-- .servicesInfo -->
                                </a><!-- .servicesInfoTop -->
                            </div>
                        <?php $i++; endif; ?>
                    <?php endforeach; ?>
                    <?php if($i==0): ?>
                        <p>В данной категории пока нет шаблонов!</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>

    </section>
    <section class="page_text">
        <?=$page['text']?>
    </section>

</section>

<script type="text/javascript">
    $(document).ready(function(){
        $('div[id=category-new]').show();

        $('#categories').on('click', 'a', function(e) {
            e.preventDefault();

            var _self = $(this);
            $('#categories li').removeClass('active');
            var category = _self.data('category');

            $('div[id^=category-]').fadeOut(200);
            setTimeout(function(){
                $('div[id=category-'+ category +']').stop(true,true).fadeIn(300);
            },200);


            _self.parent().addClass('active');
        });
    });//END READY
</script>