<?php defined('VIZITKI') or die('Access denied'); ?>

</head>

<body>

<?php
    include 'header.php';
?>

<section id="papers" class="list">
    <h2>Типы бумаги</h2>
    <table class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th>Наименование</th>
            <th>Опубликован</th>
            <th>Обложка</th>
            <th>Цена за 100 штук</th>
            <th>Цена за 1000 штук</th>
            <th>Операции</th>
        </tr>
        </thead>
        <tbody>
        <?php if($papers): ?>
            <?php foreach($papers as $paper): ?>
                <tr id="paper-<?=$paper['id']?>">
                    <td><h4><?= $paper['title'] ?></h4></td>
                    <td><?=($paper['is_active'] == 1)? '<span class="label label-success">Да</span>' : '<span class="label label-danger">Нет</span>'?></td>
                    <td class="preview"><img src="<?=($paper['image'] != null ? PATH.'/uploads/paper_type/'.$paper['image'] : PATH.'/uploads/paper_type/none_paper.jpg') ?>" alt="<?= $paper['title'] ?>"/></td>
                    <td><?=$paper['price1']?> грн</td>
                    <td><?=$paper['price2']?> грн</td>
                    <td><p><a href="<?=PATH.ADMIN?>catalog/paper/<?=$paper['id']?>">Просмотр/Редактировать</a></p><p><a class="delete_paper" data-paper="<?=$paper['id']?>" href="#">Удалить</a></p></td>
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

<section id="delete_paper_window">
    <div class="w_header">
        <h3>Удаление типа бумаги</h3>
        <p id="close">X</p>
    </div>
    <div class="w_body">
        <p>Вы уверены, что хотите удалить тип бумаги &laquo;<strong></strong>&raquo;?</p>
        <button id="del_paper" class="btn btn-danger">Да, удалить</button>
        <button id="no" class="btn btn-primary">Отмена</button>
    </div>
</section>