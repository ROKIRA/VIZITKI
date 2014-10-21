<?php defined('VIZITKI') or die('Access denied'); ?>

<?php

	session_start();

    $admin_index = false;
    if(!isset($url)){
        $admin_index = true;

        require_once './../routes.php';

        require_once './model/model.php';

        require_once './../functions/functions.php';

    }else{
        require_once './admin/model/model.php';
		
        require_once 'functions/functions.php';
    }


/*********************** ENTER TO ADMIN PANEL ********************************/
    if(!getSession('admin_auth') && $view != 'auth'){
        $ref = $_SERVER['URL'];
        redirectTo('/admin/auth');
        exit();
    }
    function adminAuth(){
        $login = $_POST['login'];
        $password = $_POST['password'];
        //ed($login.' - '.$password.'<br/>'. ADMIN_LOGIN.' - '. ADMIN_PASSWORD);

        if($login == ADMIN_LOGIN && $password == ADMIN_PASSWORD){
            setSession('admin_auth', true);
            redirectTo(ADMIN);
        }else{
            setSession('admin_error', 'Некоректно введены логин или пароль!');
        }
    }


/**----------------------------------------------------
// ================ EDIT SERVICE =================== //
----------------------------------------------------**/
function addService($group){
    $error = '';
    if(!empty($_FILES)) {
        $i = 0;
        $uploadDir = 'uploads/services/';
        foreach ($_FILES as $file) {
            if (!$file['error']) {
                $type = explode('/', $file['type']);
                if ($type[0] != 'image') {
                    $error = 'Можно загружать только изображения';
                    setSession('admin_errors', "<li>$error</li>");
                    redirect();
                    exit();
                }
                if ($file['size'] > 2200000) {
                    $error = 'Нельзя загружать файлы более <strong>2 МБ</strong>';
                    setSession('admin_errors', "<li>$error</li>");
                    redirect();
                    exit();
                }

                if ($error == '') {
                    $type = explode('/', $file['type']);
                    if ($i == 0) {
                        $uploadImageName = $group['alias'];
                        $uploadImage = $uploadDir . $uploadImageName . '.' . $type[1];

                        $success = is_uploaded_file($file['tmp_name']);
                        if ($success) {
                            move_uploaded_file($file['tmp_name'], $uploadImage);
                            $group['image'] = $uploadImageName .'.'. $type[1];
                        }

                        $i = 1;
                    } elseif ($i == 1 && !$file['error']) {
                        $uploadImageHoverName = $group['alias'];
                        $uploadImage = $uploadDir . $uploadImageHoverName . '_hover.' . $type[1];

                        $success = is_uploaded_file($file['tmp_name']);
                        if ($success) {
                            move_uploaded_file($file['tmp_name'], $uploadImage);
                            $group['imageHover'] = $uploadImageHoverName .'_hover.'. $type[1];
                        }
                    }
                }
            }else{
                $error .= '<li class="error">Выберете обложку для новой группы товаров</li>';
            }
        }
    }

    if($group['title'] == ''){
        $error .= '<li class="error">Поле <strong>&laquo;Наименование группы товаров&raquo;</strong> не должно быть пустым</li>';
    }
    if($group['pageText'] == ''){
        $error .= '<li>Поле <strong>&laquo;Описание группы товаров&raquo;</strong> не должно быть пустым</li>';
    }
    if($group['pageH1'] == ''){
        $error .= '<li>Поле <strong>&laquo;Заголовок H1&raquo;</strong> не должно быть пустым</li>';
    }
    if($group['pageTitle'] == ''){
        $error .= '<li>Поле <strong>&laquo;Заголовок TITLE&raquo;</strong> не должно быть пустым</li>';
    }
    if($group['pageKeywords'] == ''){
        $error .= '<li>Поле <strong>&laquo;Заголовок KEYWORDS&raquo;</strong> не должно быть пустым</li>';
    }
    if($group['pageDescription'] == ''){
        $error .= '<li>Поле <strong>&laquo;Заголовок DESCRIPTION&raquo;</strong> не должно быть пустым</li>';
    }

    if($error == ''){
        if(!saveAddedService($group)){
            setSession('admin_errors', '<li>Ошибка сохранения в базу данных!</li>');
            redirect();
            exit();
        }else{
            unset($_SESSION['admin_errors']);
            redirect();
        }
    }else{
        setSession('admin_errors', $error);
        redirect();
        exit;
    }

    return true;
}
/************************* ****************************/



/**----------------------------------------------------
// ================ EDIT SERVICE =================== //
----------------------------------------------------**/
function editService($group){
    $error = '';
    if(!empty($_FILES)) {
        $i = 0;
        $uploadDir = 'uploads/services/';
        foreach ($_FILES as $file) {
            if (!$file['error']) {
                $type = explode('/', $file['type']);
                if ($type[0] != 'image') {
                    $error = 'Можно загружать только изображения';
                    setSession('admin_errors', "<li>$error</li>");
                    redirect();
                    exit();
                }
                if ($file['size'] > 2200000) {
                    $error = 'Нельзя загружать файлы более <strong>2 МБ</strong>';
                    setSession('admin_errors', "<li>$error</li>");
                    redirect();
                    exit();
                }

                if ($error == '') {
                    $type = explode('/', $file['type']);
                    if ($i == 0) {
                        $var = end(explode(".", $group['image']));
                        $uploadImageName = str_replace($var, '', $group['image']);
                        $uploadImage = $uploadDir . $uploadImageName . $type[1];

                        $success = is_uploaded_file($file['tmp_name']);
                        if ($success) {
                            move_uploaded_file($file['tmp_name'], $uploadImage);
                            $group['image'] = $uploadImageName . $type[1];
                        }

                        $i = 1;
                    } elseif ($i == 1 && !$file['error']) {
                        $var = end(explode(".", $group['imageHover']));
                        $uploadImageHoverName = str_replace($var, '', $group['imageHover']);
                        $uploadImage = $uploadDir . $uploadImageHoverName . $type[1];

                        $success = is_uploaded_file($file['tmp_name']);
                        if ($success) {
                            move_uploaded_file($file['tmp_name'], $uploadImage);
                            $group['imageHover'] = $uploadImageHoverName . $type[1];
                        }
                    }
                }
            }
        }
    }

    $error = '';
    if($group['title'] == ''){
        $error .= '<li class="error">Поле <strong>&laquo;Наименование группы товаров&raquo;</strong> не должно быть пустым</li>';
    }
    if($group['pageText'] == ''){
        $error .= '<li>Поле <strong>&laquo;Описание группы товаров&raquo;</strong> не должно быть пустым</li>';
    }
    if($group['pageH1'] == ''){
        $error .= '<li>Поле <strong>&laquo;Заголовок H1&raquo;</strong> не должно быть пустым</li>';
    }
    if($group['pageTitle'] == ''){
        $error .= '<li>Поле <strong>&laquo;Заголовок TITLE&raquo;</strong> не должно быть пустым</li>';
    }
    if($group['pageKeywords'] == ''){
        $error .= '<li>Поле <strong>&laquo;Заголовок KEYWORDS&raquo;</strong> не должно быть пустым</li>';
    }
    if($group['pageDescription'] == ''){
        $error .= '<li>Поле <strong>&laquo;Заголовок DESCRIPTION&raquo;</strong> не должно быть пустым</li>';
    }

    if($error == ''){
        if(!saveEditedService($group)){
            setSession('admin_errors', '<li>Ошибка сохранения в базу данных!</li>');
            redirect();
            exit();
        }else{
            unset($_SESSION['admin_errors']);
            redirect();
        }
    }else{
        setSession('admin_errors', $error);
        redirect();
        exit;
    }

    return true;
}
/************************* ****************************/



/**----------------------------------------------------
// DOWNLOAD USER TEMPLATE IMAGES FROM ORDER FOLDER   //
----------------------------------------------------**/
    function getOrderLayouts($id){

        $dir = './uploads/orders/'.$id.'/';

        if($files = scandir($dir)){
            unset($files[0]);
            unset($files[1]);
            $files = array_values($files);

            for($i=0; $i<count($files); $i++){
                $layouts[$i]['src'] = $dir.$files[$i];
                $layouts[$i]['type'] = end(explode(".", $files[$i]));
                $layouts[$i]['size'] = ceil(filesize($dir.$files[$i]) / 1024) < 1024 ? ceil(filesize($dir.$files[$i]) / 1024) . ' Кб' : (round(filesize($dir.$files[$i]) / 1024 / 1024, 2)) . ' Мб';
            }
        }else{
            return false;
        }

        return $layouts;
    }


/********** DELETE ORDERS **********/
    if(isset($_POST['del_order_id'])){
        $order_id = $_POST['del_order_id'];
        if(deleteOrder($order_id)){
            removeOrderLayouts($order_id);
            echo 'OK';
        }
        else{
            echo 'Error!';
        }
        exit();
    }
/********** DELETE GROUPS|SERVICES **********/
    if(isset($_POST['del_group_id'])){
        $group_id = $_POST['del_group_id'];
        if($images = deleteGroup($group_id)){
            removeGroupLayouts($images);
            echo 'OK';
        }
        else{
            echo 'Error!';
        }
        exit();
    }



/**=================================================================================================
-------------------      DOWNLOAD CONTENT FOR VIEWS AND SWITCH FUNCTIONS      ----------------------
===================================================================================================**/
    switch($view){
        case('auth'):
            $auth = true;
            if(isset($_POST['admin_auth'])){
                adminAuth();
            }
        break;
        case('admin_logout'):
            unset($_SESSION['admin_auth']);
            redirect();
        break;

        case('admin_orders'):
            $orders = getOrders();
            $users = getUsersForOrders($orders);
        break;

        case('admin_order'):
            $order = getOrder($order_id);
            $user = getUserForOrder($order['user_id']);
            if(!$user){
                setSession('admin', array('error' => 'database_error' ));
            }else{
                unset($_SESSION['admin']['error']);
            }

            $tiraj = getTiraj($order['tiraj']);

            if(!$tiraj){
                setSession('admin', array('error' => 'database_error' ));
            }

            if(!empty($order['paper_type'])){
                $paper = getPaperType($order['paper_type']);
            }

            if($order['layout']){
                $layouts = getOrderLayouts($order_id);
            }

            if(isset($_POST['edit_order'])){
                $order_id = $_POST['order_id'];
                $order_status = $_POST['order_status'];
                editOrder($order_id, $order_status);
                redirect();
            }

        break;

        case('admin_del_order'):
            $order_id = $_POST['id'];
            deleteOrder($order_id);
            removeOrderLayouts($order_id);
            redirectTo(ADMIN);
        break;


        case('admin_catalog'):
            switch($catalog_alias){
                case('group_list'):
                    $groups = getAdminServices();
                    $view = 'group_list';
                break;

                case('group_add'):
                    if(isset($_POST['group_add'])){
                        if(isset($_POST['group_active'])){
                            $active = 1;
                        }else{
                            $active = 0;
                        }
                        if(isset($_POST['group_size'])){
                            $size = $_POST['group_size'];
                        }else{
                            $size = NULL;
                        }
                        $add_group = array(
                            'title' => trim($_POST['group_name']),
                            'alias' => str2url(trim($_POST['group_name'])),
                            'size' => $size,
                            'is_active' => $active,
                            'pageText' => trim($_POST['group_text']),
                            'pageH1' => trim($_POST['group_h1']),
                            'pageAlias' => 'catalog_'.str2url(trim($_POST['group_name'])),
                            'pageTitle' => trim($_POST['group_title']),
                            'pageKeywords' => trim($_POST['group_keywords']),
                            'pageDescription' => trim($_POST['group_description']),
                        );
                        $add_group['alias'] = checkServiceAlias($add_group['alias']);
                        addService($add_group);
                    }

                    $view = 'group_add';
                break;

                default:
                    include VIEW.'error404.php';
                exit();
            }
        break;

        case('admin_catalog_item'):
            switch($catalog_alias){
                case('group'):
                    $group = getAdminService($item_id);
                    if(!$group) $_SESSION['admin']['error'] = 'database_error';
                        else unset($_SESSION['admin']['error']);

                    $groupContent = getGroupDescription('catalog_'.$group['alias']);
                    if(!$groupContent) $_SESSION['admin']['error'] = 'database_error';
                        else unset($_SESSION['admin']['error']);

                    if(isset($_POST['group_edit'])){
                        if(isset($_POST['group_active'])){
                            $active = 1;
                        }else{
                            $active = 0;
                        }
                        $edit_group = array(
                            'id' => $group['id'],
                            'title' => trim($_POST['group_name']),
                            'alias' => trim($_POST['alias']),
                            'newalias' => str2url(trim($_POST['group_name'])),
                            'size' => trim($_POST['group_size']),
                            'is_active' => $active,
                            'image' => $group['image'],
                            'imageHover' => $group['image_hover'],
                            'pageText' => trim($_POST['group_text']),
                            'pageH1' => trim($_POST['group_h1']),
                            'pageAlias' => 'catalog_'.str2url(trim($_POST['group_name'])),
                            'pageTitle' => trim($_POST['group_title']),
                            'pageKeywords' => trim($_POST['group_keywords']),
                            'pageDescription' => trim($_POST['group_description']),
                        );
                       editService($edit_group);
                    }

                    $view = 'group_edit';
                break;


                default:
                    include VIEW.'error404.php';
                    exit();
            }
        break;


        default:
            include VIEW.'error404.php';
            exit();

    } // END SWITCH


if(($admin_index)){
    // HEAD
    include VIEW.'head.php';

    // CONTENT
    include VIEW.$view.'.php';

    // FOOTER
    if(!$auth){
        include VIEW.'footer.php';
    }
}else{

    // HEAD
    require '.'.ADMIN.VIEW.'head.php';

    // CONTENT
    include '.'.ADMIN.VIEW.$view.'.php';

    // FOOTER
    if(!$auth){
        include '.'.ADMIN.VIEW.'footer.php';
    }
}