<?php defined('VIZITKI') or die('Access denied'); ?>


</head>

<body>

<?php
    include 'header.php';
?>
<section id="paper">
    <?php if($paper): ?>
        <?php if(!isset($_SESSION['admin']['error'])): ?>

        <h2>Бумага <strong>&laquo;<?=$paper['title']?>&raquo;</strong></h2>
        <form action="" method="post" enctype="multipart/form-data">
            <?php if($errors = getSession('admin_errors')): ?>
                <ul class="alert alert-danger">
                    <?=$errors?>
                </ul>
            <?php endif; ?>
            <?php if($msg = getSession('admin_success')): ?>
                <div class="alert alert-success">
                    <?=$msg?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="paper_title">Наименование типа бумаги:</label>
                <input class="form-control" name="paper_title" id="paper_title" type="text" value="<?=htmlspecialchars($paper['title'])?>" />
            </div>

            <div class="form-group">
                <label for="paper_density">Плотность:</label>
                <input class="form-control" name="paper_density" id="paper_density" type="text" value="<?=htmlspecialchars($paper['density'])?>" />
            </div>

            <div class="form-group">
                <label for="paper_facture">Фактура:</label>
                <input class="form-control" name="paper_facture" id="paper_facture" type="text" value="<?=htmlspecialchars($paper['facture'])?>" placeholder="Необязательно"/>
            </div>

            <div class="form-group">
                <label for="paper_color">Цвет:</label>
                <input class="form-control" name="paper_color" id="paper_color" type="text" value="<?=htmlspecialchars($paper['color'])?>" />
            </div>

            <div class="form-group">
                <label for="paper_price1">Цена за 100 штук:</label>
                <input class="form-control" name="paper_price1" id="paper_price1" type="text" value="<?=htmlspecialchars($paper['price1'])?>" />
            </div>

            <div class="form-group">
                <label for="paper_price2">Цена за 1000 штук:</label>
                <input class="form-control" name="paper_price2" id="paper_price2" type="text" value="<?=htmlspecialchars($paper['price2'])?>" />
            </div>

            <div class="form-group">
                <label class="checkbox" for="paper_active">Публиковать</label>
                <input name="paper_active" id="paper_active" type="checkbox" <?php if($paper['is_active'] == 1) echo 'checked' ?> />
            </div>

            <div class="preview">
                <h5>Файл-обложка:</h5>
                <figure>
                    <img class="img-responsive" src="<?= PATH.'/uploads/paper_type/'.$paper['image'] ?>" alt="<?= $paper['title'] ?>"/>
                </figure>
                <label for="paper_image" class="btn btn-primary">Изменить</label>
                <input type="file" name="paper_image" id="paper_image"/>
            </div>

            <input class="btn btn-success" name="paper_edit" type="submit" value="Сохранить"/>
        </form>

        <?php else: ?>
            <div class="error"><?=$_SESSION['admin']['error']?></div>
        <?php endif; ?>
    <?php else: ?>
        <h4>Такого типа бумаги не существует!</h4>
    <?php endif; ?>
</section>

<?php unset($_SESSION['admin_errors'], $_SESSION['admin']['error'], $_SESSION['admin_success']); ?>

<script type="text/javascript">
    $(document).ready(function(){
        // check for support file API
        if(window.File && window.FileReader && window.FileList && window.Blob) {
            $('input[type=file]').on('change', function(e){
                var
                    a = $(this).parent(),
                    f = e.target.files[0], // First Chosen File
                    reader = new FileReader,
                    place = a.find('img') // Here show image
                    ;
                reader.readAsDataURL(f);
                if(/image.*/.test(f.type)) {
                    reader.onload = function(e) { // when image is upload
                        place.attr('src',e.target.result);
                    }
                }
            });
        } else {
            console.warn( "Ваш браузер не поддерживает FileAPI")
        }
    }); //END READY
</script>