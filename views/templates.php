<?php defined('VIZITKI') or die('Access denied'); ?>

<div class="templates">
    <?php foreach($templates as $tpl): ?>
        <div class="servicesBlock_group">
            <a class="servicesInfoTop_group" id="tpl-<?=$tpl['id']?>" data-group="<?=$tpl_alias?>" data-id="<?=$tpl['id']?>" href="#">
                <img alt="<?=$tpl['name']?>" src="
                            <?=($tpl['preview'] ? PATH.'/uploads/templates/'.$tpl['preview'] : PATH.'/uploads/no_image.jpg')?>
                        "/>
                <div class="servicesInfo_group">
                    <div class="like-h5"><?=$tpl['name']?></div>
                </div><!-- .servicesInfo -->
            </a><!-- .servicesInfoTop -->
        </div>
    <?php endforeach; ?>
</div>