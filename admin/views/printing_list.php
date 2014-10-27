<?php defined('VIZITKI') or die('Access denied'); ?>

</head>

<body>

<?php
include 'header.php';
?>

<section id="printings" class="list">
    <h2>Список тиражей</h2>
    <table class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th>Количество</th>
            <th>Тип</th>
            <th>Цена</th>
            <th>Группа</th>
            <th>Публиковать</th>
            <th>Операции</th>
        </tr>
        </thead>
        <tbody>
        <?php if($printings): ?>
            <?php foreach($printings as $printing): ?>
                <tr id="printing-<?=$printing['id']?>">
                    <td><h4><?= $printing['count'] ?> штук</h4></td>
                    <td><?= ($printing['type_side'] == 1 ? 'односторонние' : 'двусторонние') ?></td>
                    <td><?=$printing['price']?> грн</td>
                    <td><h4><?=$printing['group']?></h4></td>
                    <td><?=($printing['is_active'] == 1)? '<span class="label label-success">Да</span>' : '<span class="label label-danger">Нет</span>'?></td>
                    <td><p><a href="<?=PATH.ADMIN?>catalog/printing/<?=$printing['id']?>">Просмотр/Редактировать</a></p><p><a class="delete_printing" data-printing="<?=$printing['id']?>" href="#">Удалить</a></p></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Тиражей пока нет!</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</section>

<section id="delete_printing_window">
    <div class="w_header">
        <h3>Удаление тиража</h3>
        <p id="close">X</p>
    </div>
    <div class="w_body">
        <p>Вы уверены, что хотите удалить тираж &laquo;<strong></strong>&raquo;?</p>
        <button id="del_printing" class="btn btn-danger">Да, удалить</button>
        <button id="no" class="btn btn-primary">Отмена</button>
    </div>
</section>