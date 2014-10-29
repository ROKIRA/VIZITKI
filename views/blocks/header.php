<header>
<div class="site_size">
<div class="hTop">
    <div class="logoBlock">
        <a href="/"><img src="<?=ASSET?>/images/logo.png"></a>
    </div>
    <?php require_once 'mainMenu.php' ?>
    <div class="hTop_right">
        <section class="header_basket">
            <a href="<?=PATH.'/basket'?>">
                <?php $count = getSession('basket')? count(getSession('basket')) : 0 ?>
                <strong <?php if($count == 0) echo 'class="empty"'; ?>>
                    <?=$count?>
                </strong>
                <?php if($count == 0 || $count > 4): ?>товаров<?php endif; ?>
                <?php if($count == 1): ?>товар<?php endif; ?>
                <?php if($count > 1 && $count < 4): ?>товара<?php endif; ?>
            </a>
        </section>
    </div>


</div>
</div>

</header>
<section class="header_b">
    <div class="site_size">

        <address>
            <span>+38 (050) 807-85-86</span>
            <span>+38 (096) 807-85-86</span>
        </address>

        <div class="social">
            <ul>
                <li><a href="#"><img src="<?=ASSET?>images/vk.png" alt="вконтакте"/></a></li>
                <li><a href="#"><img src="<?=ASSET?>images/fb.png" alt="одноклассники"/></a></li>
                <li><a href="#"><img src="<?=ASSET?>images/ok.png" alt="facebook"/></a></li>
            </ul>
        </div>

        <div class="login">
            <p><?php $user = getSession('USER');
                if(isset($user['login'])): ?>
                    <strong><a href="#"><?=$user['login']?></a></strong>, <a href="<?=PATH.'/logout'?>">Выйти</a>
                <?php else: ?>
                <a id="auth" href="#">Вход</a>
                <section id="login">
                        <div class="auth_header">
                            <h3>Авторизация</h3>
                            <p id="close">X</p>
                        </div>
                    <?php if($error = getSession('error')): ?>
                    <p class="error"><?=$error?></p>
                    <?php unset($_SESSION['error']); endif; ?>
                        <form action="<?= PATH . '/login' ?>" method="post">
                            <input type="text" name="login" placeholder="Ваш логин" required/>
                            <input type="password" name="password" placeholder="Ваш пароль" required/>
                            <input type="submit" name="auth" value="Войти"/>
                        </form>
                        <a href="<?=PATH.'/registration'?>">Регистрация</a>
                        <a href="<?=PATH.'/forget-password'?>">Забыли пароль</a>
                </section>
                <?php endif; ?>
        </div>
        <div class="clear"></div>

</div>
</section>