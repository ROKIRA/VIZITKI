<nav class="mainMenu">

    <ul id="navigation" class="nav-main">
        <?php foreach($mainMenu as $link): ?>
            <li <?php if(PATH.$link['url'] == PATH.$url) echo 'class="active"' ?> ><a href="<?=PATH.$link['url']?>" <?=$link['attr']?> ><?=htmlspecialchars($link['title'])?></a></li>
        <?php endforeach; ?>
        </ul>
</nav><!-- .main_menu -->