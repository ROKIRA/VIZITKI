<?php defined('VIZITKI') or die ('Access denied'); ?>

<header>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=PATH.ADMIN?>">Заказы</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Каталог <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?=PATH.ADMIN?>catalog/group_list">Группы товаров</a></li>
                            <li><a href="<?=PATH.ADMIN?>catalog/group_add">Добавить группу товаров</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=PATH.ADMIN?>catalog/paper_list">Типы бумаги</a></li>
                            <li><a href="<?=PATH.ADMIN?>catalog/paper_add">Добавить тип бумаги</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=PATH.ADMIN?>catalog/printing_list">Тиражи</a></li>
                            <li><a href="<?=PATH.ADMIN?>catalog/printing_add">Добавить тираж</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                </ul>
                <!--<form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>-->
                <ul class="nav navbar-nav navbar-right">
                    <li><a id="configs" href="#">НАСТРОЙКИ</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?=PATH.ADMIN?>logout">Выйти</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

</header>
