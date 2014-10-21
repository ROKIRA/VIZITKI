<header>
<div class="site_size">
<div class="hTop">
    <div class="logoBlock">
        <a href="/"><img src="<?=ASSET?>/images/logo.png"></a>
    </div>
    <div class="hTop_right">
        <section class="header_basket">
            <a href="<?=PATH.'/basket'?>"><img src="<?=ASSET?>/images/shop.png"></a>
            <p>
                В корзине <strong>
                    <?php $count = getSession('basket')? count(getSession('basket')) : 0; echo $count; ?>
                </strong>
                <?php if($count == 0 || $count > 4): ?>товаров<?php endif; ?>
                <?php if($count == 1): ?>товар<?php endif; ?>
                <?php if($count > 1 && $count < 4): ?>товара<?php endif; ?>
            </p>
        </section>
    <div class="login">
    <p><?php $user = getSession('USER');
                if(isset($user['login'])): ?>
                <strong><?=$user['login']?>, <a href="<?=PATH.'/logout'?>">Выйти</a></strong>
            <?php else: ?>
                <a href="#">Вход</a>&nbsp;/&nbsp;<a href="<?=PATH.'/registration'?>">Регистрация</a>
                <section id="login">
                    <?php if($error = getSession('error')): ?>
                        <p class="error"><?=$error?></p>
                    <?php unset($_SESSION['error']); endif; ?></p>
    </div>
    </div>
    <div class="hTop_center">

    </div>
</div>
<div class="centerBlock">
            <address>

            </address>
        </div>


        <div id="auth">
        
                <form action="<?= PATH . '/login' ?>" method="post">
                    <input type="text" name="login" placeholder="Ваш логин"/>
                    <input type="password" name="password" placeholder="Ваш Пароль"/>
                    <input type="submit" name="auth" value="Войти"/>
                </form>
            </section>
        <?php endif; ?>
        </div>

        

    </div>

    <?php require_once 'mainMenu.php' ?>

</header>