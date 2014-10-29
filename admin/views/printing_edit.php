<?php defined('VIZITKI') or die('Access denied'); ?>


</head>

<body>

<?php
    include 'header.php';
?>
<section id="printing">
    <?php if($printing): ?>
        <?php if(!isset($_SESSION['admin']['error'])): ?>

        <h2>Тираж <strong>&laquo;<?=$printing['text']?>&raquo;</strong></h2>
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
                <label for="printing_count">Количество:</label>
                <input class="form-control" name="printing_count" id="printing_count" type="text" value="<?=htmlspecialchars($printing['count'])?>" />
            </div>

            <div class="form-group">
                <label for="printing_price">Цена:</label>
                <input class="form-control" name="printing_price" id="printing_price" type="text" value="<?=htmlspecialchars($printing['price'])?>" />
            </div>

            <div class="form-group">
                <label for="printing_type">Тип:</label>
                <select id="printing_type" class="form-control" name="printing_type">
                    <option value="1" <?php if($printing['type_side'] == 1) echo 'selected' ?>>Односторонние</option>
                    <option value="2" <?php if($printing['type_side'] == 2) echo 'selected' ?>>Двусторонние</option>
                </select>
            </div>

            <div class="form-group">
                <label for="printing_type">Группа товаров:</label>
                <?php if($groups): ?>
                <select id="printing_type" class="form-control" name="printing_type">
                    <?php foreach($groups as $group): ?>
                        <option value="<?=$group['alias']?>"><?=$group['title']?></option>
                    <?php endforeach; ?>
                </select>
                <?php endif; ?>
            </div>

            <input class="btn btn-success" name="printing_edit" type="submit" value="Сохранить"/>
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