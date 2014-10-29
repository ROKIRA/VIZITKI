<?php defined('VIZITKI') or die('Access denied'); ?>

    <section class="registration">
        <h3>Восстановление пароля</h3>

        <?php if($error = getSession('error')): ?>
            <p class="error"><?=$error?></p>
        <?php $user_email = getSession('user_email'); endif; ?>

        <form action="" method="post">

            <p>Введите Ваш адрес электронной почты и мы вышлем Вам пароль для входа.</p>
            <div class="row">
                <label for="email">Email: </label>
                <input type="text" name="email" id="email"  placeholder="Email" value="<?=$user_email?>"/>
            </div>

            <input type="submit" name="send_password" id="send_password" value="Отправить"/>
        </form>

    </section>

<?php unset($_SESSION['error']); ?>