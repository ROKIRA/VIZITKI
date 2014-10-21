<section class="mainMenu">

    <ul id="navigation" class="nav-main">
        <?php foreach($mainMenu as $link): ?>
            <li><a href="<?=PATH.$link['url']?>" <?=$link['attr']?> ><?=htmlspecialchars($link['title'])?></a></li>
        <?php endforeach; ?>
        </ul>
</section><!-- .main_menu -->