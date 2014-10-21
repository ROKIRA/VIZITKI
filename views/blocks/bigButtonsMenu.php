<div class="bigButtonsMenu">
    <ul class="bBtn">
        <?php foreach($bigButtonsMenu as $link): ?>
            <li><a href="<?=PATH.$link['url']?>" <?=$link['attr']?> ><?=htmlspecialchars($link['title'])?></a></li>
        <?php endforeach; ?>
    </ul>
</div>