<?php defined('VIZITKI') or die('Access denied'); ?>


</head>

<body>

<?php
    include 'header.php';
?>
<section id="group">
    <h2>Добавление группы товаров</h2>
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
            <label for="group_name">Наименование группы товаров:</label>
            <input class="form-control" name="group_name" id="group_name" type="text" value="<?=htmlspecialchars($group['title'])?>" />
        </div>

        <div class="form-group">
            <label for="group_size">Размер группы товаров (необязательно):</label>
            <input class="form-control" name="group_size" id="group_size" type="text" value="<?=htmlspecialchars($group['size'])?>" placeholder="Необязательно" />
        </div>

        <div class="form-group">
            <label for="group_text">Описание группы товаров:</label>
            <textarea class="form-control" name="group_text" id="group_text" cols="30" rows="10"><?=htmlspecialchars($groupContent['text'])?></textarea>
        </div>

        <div class="preview">
            <h5>Файл-обложка:</h5>
            <figure>
                <img class="img-responsive" src="<?= PATH.'/uploads/services/vizitki.png' ?>" alt="<?= $group['alias'] ?>"/>
            </figure>
            <label for="group_image" class="btn btn-primary">Выбрать</label>
            <input type="file" name="group_image" id="group_image"/>
        </div>

        <div class="preview">
            <h5>Файл-обложка при наведение указателя:</h5>
            <figure>
                <img class="img-responsive" src="<?= PATH.'/uploads/services/vizitki_hover.png' ?>" alt="<?= $group['alias'] ?>"/>
            </figure>
            <label for="group_image_hover" class="btn btn-primary">Выбрать</label>
            <input type="file" name="group_image_hover" id="group_image_hover" />
        </div>

        <div class="form-group">
            <label class="checkbox" for="group_active">Публиковать</label>
            <input name="group_active" id="group_active" type="checkbox" />
        </div>

        <div class="form-group">
            <label for="group_h1">Заголовок H1 (для поисковых систем):</label>
            <input class="form-control" name="group_h1" id="group_h1" type="text" value="<?=htmlspecialchars($groupContent['h1'])?>" />
        </div>

        <div class="form-group">
            <label for="group_title">Заголовок TITLE (для поисковых систем):</label>
            <input class="form-control" name="group_title" id="group_title" type="text" value="<?=htmlspecialchars($groupContent['title'])?>" />
        </div>

        <div class="form-group">
            <label for="group_keywords">Заголовок KEYWORDS (для поисковых систем):</label>
            <textarea class="form-control" name="group_keywords" id="group_keywords" cols="30" rows="3"><?=htmlspecialchars($groupContent['keywords'])?></textarea>
        </div>

        <div class="form-group">
            <label for="group_description">Заголовок DESCRIPTION (для поисковых систем):</label>
            <textarea class="form-control" name="group_description" id="group_description" cols="30" rows="3"><?=htmlspecialchars($groupContent['description'])?></textarea>
        </div>

            <input class="btn btn-primary" name="group_add" type="submit" value="Сохранить"/>
    </form>
</section>

<?php unset($_SESSION['admin_errors'], $_SESSION['admin_success']); ?>


<script type="application/javascript">
    CKEDITOR.replace('group_text');
</script>
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