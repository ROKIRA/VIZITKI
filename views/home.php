<?php defined('VIZITKI') or die('Access denied'); ?>


<section class="homepage">
    <?php if($slider):?>
        <section class="slider">
            <ul id="slider">
                <?php foreach($slider as $slide): ?>
                    <li>
                        <img src="<?=PATH?>/uploads/slider/<?=$slide['image']?>" title="<?=$slide['text']?>" alt="<?=$slide['btn_title']?>"/>
                        <a href="<?=$slide['btn_url']?>"><?=$slide['btn_title']?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php require_once 'blocks/bigButtonsMenu.php' ?>

    <section class="services">

        <?php foreach($services as $service): ?>
            <div class="service_block inlineBlock">
                <img data-hover="<?=UPLOADS?><?=($service['image_hover'] ? 'services/'.$service['image_hover'] : 'no_image.jpg')?>" src="<?=UPLOADS?><?=($service['image'] ? 'services/'.$service['image'] : 'no_image.jpg')?>" alt="<?=$service['title']?>"/>
                <div class="service_info">
                    <a href="<?=PATH?>/catalog/service/<?=$service['alias']?>" class="service_info_top">
                        <p class="like-h5"><?=$service['title']."\n"?><?=$service['size']?></p>
                        <?php if($service['price1']): ?>
                            <div class="service_price">
                                <div>
                                    <p><?=$service['count1']?> штук</p>
                                    <p><?=ceil($service['price1']*KURS)?> грн</p>
                                </div>
                                <?php if($service['price1']): ?>
                                    <div>
                                        <p><?=$service['count2']?> штук</p>
                                        <p><?=ceil($service['price2']*KURS)?> грн</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </a>
                    <div class="service_info_bot">
                        <a rel="nofollow" href="<?=PATH?>/catalog/upload-layout/<?=$service['alias']?>">Загрузите свой макет</a>
                        <a rel="nofollow" href="<?=PATH?>/catalog/order-design/<?=$service['alias']?>">Закажите дизайн</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
    <section class="page_text">
        <?=$page['text']?>
    </section>

</section>

<script type="text/javascript">
    $(document).ready(function(){

        $('#slider').bxSlider({
            mode: 'fade',
            captions: true,
            controls: false,
            auto: true,
            pause: 5000,
            minSlides: 1,
            maxSlides: 1,
            moveSlides: 1
        });

        $('.service_block').hover(function(){
            var _self = $(this).find('img');
            var src = _self.attr('src');
            var src_hover = _self.data('hover');
            _self.attr('src', src_hover);
            _self.data('hover', src);
        },function(){
            var _self = $(this).find('img');
            var src = _self.attr('src');
            var src_hover = _self.data('hover');
            _self.attr('src', src_hover);
            _self.data('hover', src);
        });

    });
</script>