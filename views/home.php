<?php defined('VIZITKI') or die('Access denied'); ?>

<section class="homepage">
    <?php require_once 'blocks/bigButtonsMenu.php' ?>

    <div class="slider">
        <ul id="slider">
            <li><img src="<?=PATH?>/uploads/" alt=""/></li>
        </ul>
    </div>

    <section class="services">

        <?php foreach($services as $service): ?>
            <div class="service_block inlineBlock">
                <img data-hover="<?=VIZITKAIMG?><?=($service['image_hover'] ? 'services/'.$service['image_hover'] : 'no_image.jpg')?>" src="<?=VIZITKAIMG?><?=($service['image'] ? 'services/'.$service['image'] : 'no_image.jpg')?>" alt="<?=$service['title']?>"/>
                <div class="service_info">
                    <a href="<?=PATH?>/catalog/service/<?=$service['alias']?>" class="service_info_top">
                        <div class="like-h5"><?=$service['title']."\n"?><?=$service['size']?></div>
                        <?php if($service['price1']): ?>
                            <div class="service_price">
                                <div>
                                    <p><?=$service['count1']?></p>
                                    <p><?=$service['price1']?></p>
                                </div>
                                <?php if($service['price1']): ?>
                                    <div>
                                        <p><?=$service['count2']?></p>
                                        <p><?=$service['price2']?></p>
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