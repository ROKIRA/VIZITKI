<?php defined('VIZITKI') or die('Access denied'); ?>

</head>

<body>

<?php
    include 'header.php';
?>

<section id="groups" class="list">
    <h2>Группы товаров</h2>
    <table class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th>Наименование</th>
            <th>Опубликован</th>
            <th>Обложка</th>
            <th>Операции</th>
        </tr>
        </thead>
        <tbody>
        <?php if($groups): ?>
            <?php foreach($groups as $group): ?>
                <tr id="group-<?=$group['id']?>">
                    <td><h4><?= $group['title'] ?></h4></td>
                    <td><?=($group['is_active'] == 1)? '<span class="label label-success">Да</span>' : '<span class="label label-danger">Нет</span>'?></td>
                    <td class="preview"><img src="<?=($group['image'] != null ? PATH.'/uploads/services/'.$group['image'] : PATH.'/uploads/no_image.jpg') ?>" alt="<?= $group['alias'] ?>"/></td>
                    <td><p><a href="<?=PATH.ADMIN?>catalog/group/<?=$group['id']?>">Просмотр/Редактировать</a></p><p><a class="delete_group" data-group="<?=$group['id']?>" href="#">Удалить</a></p></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Групп товаров пока нет!</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</section>

<section id="delete_group_window">
    <div class="w_header">
        <h3>Удаление группы товаров</h3>
        <p id="close">X</p>
    </div>
    <div class="w_body">
        <p>Вы уверены, что хотите удалить группу товаров &laquo;<strong></strong>&raquo;?</p>
        <button id="del_group" class="btn btn-danger">Да, удалить</button>
        <button id="no" class="btn btn-primary">Отмена</button>
    </div>
</section>