<?php defined('VIZITKI') or die('Access denied'); ?>

<section class="loginbox_layout">
    <section class="loginbox">
        <form role="form" method="post">
            <?php if($error = getSession('admin_error')): ?>
                <p class="alert alert-danger"><?=$error?></p>
            <?php unset($_SESSION['admin_error']); endif; ?>
            <div class="form-group">
                <label for="login">Логин:</label>
                <input type="text" name="login" class="form-control" id="login" placeholder="Введите логин">
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">
            </div>
            <input type="submit" name="admin_auth" class="btn btn-success" value="Войти" />
        </form>
    </section>
</section>