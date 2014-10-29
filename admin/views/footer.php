<?php defined('VIZITKI') or die('Access denied'); ?>

        <footer>

        </footer>

        <section id="config_window_bg">
            <section id="config_window_wrapper">
                <section id="config_window">
                    <div class="window_header">
                        <h4>Настройки</h4>
                        <p id="close_config_window">X</p>
                    </div>
                    <div id="window_body">
                        <?php if($CONFIGS): ?>
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

                            <?php foreach($CONFIGS as $config): ?>
                                <div class="form-group">
                                    <label for="config_value"><?=$config['title']?>:</label>
                                    <input class="form-control" name="config_value" id="config_value" type="text" value="<?=htmlspecialchars($config['value'])?>" />
                                </div>
                            <?php endforeach; ?>

                            <input class="btn btn-success" name="config_edit" type="submit" value="Сохранить"/>
                        </form>
                        <?php else: ?>
                            <p class="alert alert-info">Настроек пока нет!</p>
                        <?php endif; ?>
                    </div>
                </section>
            </section>
        </section>

    <script type="text/javascript">
        var open_config_window = $('#configs');
        var layout = $('#config_window_bg');
        var modal_window = $('#config_window');
        var close_window = $('#close_config_window');
        var window_body = $('#window_body');

        function closeWindow(){
            modal_window.slideUp(500);
            setTimeout(function(){
                layout.fadeOut(500);
            }, 300);
        }

        open_config_window.on('click', function(e){
            e.preventDefault();
            layout.fadeIn(300);
            setTimeout(function(){
                modal_window.slideDown(400);
            }, 200);
        });

        close_window.on('click', function(){
            closeWindow();
        });

    </script>

        </body>
    </html>