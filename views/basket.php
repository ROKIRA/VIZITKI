<div id="basket" class="basket_wrapper">
    <h1 class="title">Оформление заказа</h1>
    <div class="breadcrumbs">
        <span><a href="/">Главная</a></span>  <span>Оформление заказа</span>
    </div>

    <?php print_arr($_SESSION) ?>

    <?php if($msg = getSession('success')): ?>
        <div class="success"><?=$msg?></div>
        <?php unset($_SESSION['success']); ?>
    <?php else: ?>
        <?php if($basket = getSession('basket')): ?>
            <table id="basket_goods">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Заказ</th>
                        <th>&nbsp;</th>
                        <th>Количество комплектов</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
                <tbody>
                <?php //print_arr($basket); ?>
                    <?php $i=1; $index=0; $totalSum=0; foreach($basket as $item): ?>
                        <tr>
                            <td><a href="<?=PATH.'/basket/delete/'.($i-1)?>">del</a></td>
                            <td>
                                <?php if(isset($item['image_face']) && $item['image_face'] != NULL): ?>
                                    <img style="max-width: 100px; max-height: 60px" src="<?=$item['image_face']?>" alt="<?=$item['type']?>"/>
                                    <?php if($item['image_back'] != NULL): ?>
                                        <br/>
                                        <img style="max-width: 100px; max-height: 60px" src="<?=$item['image_back']?>" alt="<?=$item['type']?>"/>
                                    <?php endif; ?>
                                <?php elseif(isset($layouts) && !empty($layouts)): ?>
                                    <?php $j=1; foreach($layouts as $layout): ?>
                                        <div class="layout">
                                            <?php if($layout['type'] == 'psd'): ?>
                                                <figure>
                                                    <img src="<?=ASSET?>/images/psd.png" alt="layout-<?=$j?>" style="max-width: 100px; max-height: 60px"/>
                                                </figure>
                                            <?php elseif($layout['type'] == 'tiff' || $layout['type'] == 'tif'): ?>
                                                <figure>
                                                    <img src="<?=ASSET?>/images/tiff.png" alt="layout-<?=$j?>" style="max-width: 100px; max-height: 60px"/>
                                                </figure>
                                            <?php else: ?>
                                                <figure>
                                                    <img src="<?=PATH.'/'.$layout['src']?>" alt="layout-<?=$j?>" style="max-width: 100px; max-height: 60px"/>
                                                </figure>
                                            <?php endif; ?>
                                                <p><strong>Тип:</strong> <?=$layout['type']?></p>
                                                <p><strong>Размер:</strong> <?=$layout['size']?></p>
                                        </div>
                                    <?php $j++; endforeach; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?=$item['type']?>,
                                количество <?=$item['count']?> штук
                                <?php if($item['type_sides']==1) echo '(односторонние)'; else if($item['type_sides']==2) echo '(двусторонние)'; ?>
                                <?php if($item['dop_uslugi'] != null || isset($item['paper_type'])): ?>
                                <p><strong>Дополнительно:</strong></p>
                                <?php endif; ?>
                                <?php if($item['dop_uslugi'] != null): ?>
                                    <ul>
                                        <?php
                                            $extras = explode(',',$item['dop_uslugi']);
                                            foreach($extras as $extra): ?>
                                                <?php for($i=0; $i<count($dop_uslugi); $i++): ?>
                                                    <?php if($extra['id'] == $dop_uslugi[$i]['id']): ?>
                                                    <li><?=$dop_uslugi[$i]['title']?></li>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <?php if(isset($item['paper_type'])): ?>
                                    <p><strong>Бумага:</strong></p>
                                    <p class="paper_type">
                                        <?=$item['paper_type']['title']?> (+<?=(($item['count']/$item['kolvo']) == 100 ? ceil($item['paper_type']['price1']*KURS) : ceil($item['paper_type']['price2']*KURS)) ?>грн)
                                    </p>
                                <?php endif; ?>
                            </td>
                            <td><form action="" method="post" ><input type="hidden" name="index" value="<?=$index?>"/><input type="number" name="kolvo" id="kolvo-<?=$i?>" value="<?=$item['kolvo']?>" /></form></td>
                            <td><?=$item['totalSum']?> грн</td>
                        </tr>
                    <?php $i++; $index++; $totalSum += $item['totalSum']; endforeach; ?>
                </tbody>
            </table>
            <p class="totalSum">
                <strong>ИТОГО: <?=$totalSum?> грн</strong>
            </p>


            <section class="saveOrder">
                <form action="<?=PATH?>/save/order" method="post" name="saveOrder">
                    <?php $user = getSession('USER'); if(!$user || $user['temp_user_id']): ?>
                    <div class="links">
                        <ul id="tabs">
                            <li><a href="#">Новый покупатель</a></li>
                            <li><a href="#" id="auth_from_basket">Я уже зарегестрирован</a></li>
                        </ul>
                    </div>

                    <div class="row">
                        <label class="label">ФИО</label>
                        <div class="controls">
                            <input data-error="" type="text" name="USER[name]" value="" />
                            <div class="help">Введите ваше имя, фамилию и отчество</div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="label">Телефон</label>
                        <div class="controls">
                            <input data-error="" type="text" name="USER[phone]" value=""  />
                            <div class="help">Введите ваше телефон</div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="label">E-Mail</label>
                        <div class="controls">
                            <input data-error="" name="USER[email]" type="email" value="" class="valid email" />
                            <div class="help">Введите ваш email</div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="label">Адрес доставки</label>
                        <div class="controls">
                            <input data-error="" name="USER[address]" type="text" value="" class="valid" />
                            <div class="help">Введите ваш адрес доставки</div>
                        </div>
                    </div>

                    <input type="text" name="make_order" style="display: none;" />

                    <div class="row" style="display: none;">
                        <label class="label">С шаблоном визитки согласен</label>
                        <div class="controls">
                            <input data-error="" type="text" value="1" id="agree" class="valid digits"/>
                            <div class="help">Введите ваше телефон</div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                            <input type="submit" class="submit" value="Оформить заказ" />
                    </div>
                </form>
            </section>

        <?php else: ?>
            <p class="empty_basket">
                Корзина пуста!
            </p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script type="application/javascript">
    $(document).ready(function(){
        $('input[type=number]').change(function(){
            if(confirm('Пересчитать показатели?')){
                $(this).parent().submit();
            }
        });
    });//END READY
</script>