<?php defined('VIZITKI') or die('Access denied'); ?>

<?php


/********* IF IT's ADMIN PANEL SKIP FRONTEND **********/
// if admin panel
$admin = strpos($url, 'admin');
if ($admin !== false){
    require_once './admin/index.php';
    exit();
}


    session_start();

    // INCLUDING MODEL
    require_once MODEL;

    // INCLUDING FUNCTIONS LIBRARY
    require_once 'functions/functions.php';

    // GET MAIN MENU AND FOOTER MENU LINKS
        $mainMenu = getMenu('main');
        $footerMenu = getMenu('footer');


    // GET CONFIGS
    function getSetSiteConfigs(){
        if(!getSession('CONFIGS')){
            $configs = getSiteConfigs();

            $assocConfig = array();
            foreach($configs as $config){
                $assocConfig[$config['name']] = [
                    'title' => $config['title'],
                    'value' => $config['value'],
                ];
            }

            setSession('CONFIGS', $assocConfig);
        }else{
            $assocConfig = getSession('CONFIGS');
        }


        return $assocConfig;
    }

    $configs = getSetSiteConfigs();
    $kurs = $configs['kurs']['value'];
    define('KURS', $kurs);


    // EDITOR FLAG - IF TRUE LOAD CSS AND JS RESOURCES
        $editor = false;


    /**---------------------------------------------------
    // =============== REGISTRATION NEW USER ========== //
    ---------------------------------------------------**/
    function register(){
        $user['fio'] = trim($_POST['register_fio']);
        $user['phone'] = trim($_POST['register_phone']);
        $user['email'] = trim($_POST['register_email']);
        $user['address'] = trim($_POST['register_address']);
        $user['login'] = trim($_POST['register_login']);
        $user['password'] = trim($_POST['register_password']);
        $user['password_confirm'] = trim($_POST['register_confirm_password']);

        $error = '';
        if($user['fio'] == ''){
            $error .= '<li>Поле <strong>&laquo;ФИО&raquo;</strong> должно быть заполнено!</li>';
        }
        if($user['phone'] == ''){
            $error .= '<li>Поле <strong>&laquo;Телефон&raquo;</strong> должно быть заполнено!</li>';
        }
        if($user['email'] == ''){
            $error .= '<li>Поле <strong>&laquo;Email&raquo;</strong> должно быть заполнено!</li>';
        }
        if($user['address'] == ''){
            $error .= '<li>Поле <strong>&laquo;Address&raquo;</strong> должно быть заполнено!</li>';
        }
        if($user['login'] == ''){
            $error .= '<li>Поле <strong>&laquo;Логин&raquo;</strong> должно быть заполнено!</li>';
        }
        if($user['password'] != '' && strlen($user['password']) > 5){
            if($user['password'] != $user['password_confirm']){
                $error .= '<li>Пароли не совпадают!</li>';
            }
        }else {
            $error .= '<li>Поле <strong>&laquo;Пароль&raquo;</strong> не должно быть пустым или меньше 6 символов</li>';
        }

        if($error == ''){
            $user['password'] = md5(sha1($user['password']));
            /*$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);*/
            if(!$user_id = saveUser($user)){
                setSession('errors', 'Ошибка регистрации!');
                setSession('reg_user', $user);
                redirect();
                exit();
            }
            unset($_SESSION['errors']);
            unset($_SESSION['reg_user']);
        }else{
            setSession('errors', $error);
            setSession('reg_user', $user);
            redirect();
            exit();
        }

        setSession('success', 'Вы успешно зарегестрированы!');
        setSession('USER', array(
            'user_id' => $user_id,
            'email' => $user['email'],
            'fio' => $user['fio'],
            'login' => $user['login'],
        ));
        redirectTo('/');

        return true;
    }


    /**---------------------------------------------------
    // ===================== LOGIN =================== //
    ---------------------------------------------------**/
    function logIn(){
        $login = trim($_POST['login']);
        $password = md5(sha1(trim($_POST['password'])));

        if($user = checkAndGetUser($login, $password)){
            setSession('USER', array(
                'user_id' => $user['user_id'],
                'fio' => $user['fio'],
                'email' => $user['email'],
                'login' => $user['login'],
            ));
            unset($_SESSION['error']);
        }else{
            setSession('error', 'Логин/Пароль введены неверно!');
        }

        redirect();
        exit();
    }


    /**---------------------------------------------------
    // ===================== LOGOUT =================== //
    ---------------------------------------------------**/
    function logOut(){
        unset($_SESSION['USER']);
        redirect();
        exit();
    }


    /**---------------------------------------------------
    // DOWNLOAD USER TEMPLATE IMAGES FROM TEMP FOLDER   //
    ---------------------------------------------------**/
    function getLayouts(){
        if(!$user = getSession('USER')) return NULL;

        if(!isset($user['user_id']))
            $dir = 'uploads/_tmp/'.$user['temp_user_id'].'/';
        else
            $dir = 'uploads/_tmp/'.$user['user_id'].'/';

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


    /**---------------------------------------------------------------------------------------------------------------------//
    // UPLOAD USER TEMPLATE IMAGE TO TEMP FOLDER   //
    ----------------------------------------------**/
    if(isset($_POST['uploader'])){
        if(!getSession('USER')){
           $user_id = createSessionUser();
        }
        uploadLayoutes();
    }

    function uploadLayoutes(){

        // Все загруженные файлы помещаются в папку $uploaddir
        $user = getSession('USER');
        if(isset($user['user_id'])){
            $user_folder = $user['user_id'];
        }elseif(isset($user['temp_user_id'])){
            $user_folder = $user['temp_user_id'];
        }

        mkdir('uploads/_tmp/'.$user_folder);

        $uploaddir = 'uploads/_tmp/'.$user_folder.'/';

        // Вытаскиваем необходимые данные
        $file = $_POST['data']['value'];
        $name = $_POST['data']['name'];

        // Получаем расширение файла
        $getMime = explode('.', $name);
        $mime = end($getMime);

        // Выделим данные
        $data = explode(',', $file);

        // Декодируем данные, закодированные алгоритмом MIME base64
        $encodedData = str_replace(' ','+',$data[1]);
        $decodedData = base64_decode($encodedData);

        // Мы будем создавать произвольное имя!
        $randomName = substr_replace(sha1(microtime(true)), '', 12).'.'.$mime;

        // Создаем изображение на сервере
            if(file_put_contents($uploaddir.$randomName, $decodedData)) {
                $filesize = ceil(filesize($uploaddir.$randomName) / 1024) < 1024 ? ceil(filesize($uploaddir.$randomName) / 1024) . ' Кб' : (round(filesize($uploaddir.$randomName) / 1024 / 1024, 2)) . ' Мб';
                echo $randomName.":загружен успешно:".$user_folder.':'.$mime.':'.$filesize;
            }
            else {
                // Показать сообщение об ошибке, если что-то пойдет не так.
                echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
            }

        exit();

    }

    // DELETE LAYOUT
    if(isset($_POST['delete_layout'])){
        $file = $_POST['src'];
        if(unlink($file)){
            echo (int)200;
        }else{
            echo 'Error!';
        }
        exit();
    }

    /************************ END UPLOADING USER TEMPLATES****************************/



    /**-------------------------------------------
    // UPLOAD IMAGE TO TEMP FOLDER FOR EDITOR   //
    -------------------------------------------**/
        function uploadImage(){
            $error = false;
            if(empty($_FILES)){
                return false;
            }
            $type = explode('/', $_FILES['file']['type']);
            if($type[0] != 'image'){
                $result = 'Not image!';
                $error = true;
            }
            if($_FILES['file']['size'] > 2000000){
                $result = 'Too large!';
                $error = true;
            }

            if(!$error){
                $uploadDir = 'uploads/_temp/';
                $uploadImageName = uniqid(true) .'.'. $type[1];
                $uploadImage = $uploadDir . $uploadImageName;
                //$result = array('tmp_name' => $_FILES['file']['tmp_name'], 'uploadDir' => $uploadDir, 'uploadImage' => $uploadImage);
                $success = is_uploaded_file($_FILES['file']['tmp_name']);

                if($success){
                    move_uploaded_file($_FILES['file']['tmp_name'], $uploadImage);
                    $result = '<head><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                                <script>window.jQuery || document.write(\'<script src="<?=VIEW?>js/jquery-1.11.1.min.js">\x3C/script>\')</script>
                                <script type="text/javascript">
                                 $(document).ready(function(){
                                     $("body").empty();
                                      var photo_name = "' .$uploadImageName. '";
                                      window.parent.$("#new_photo").html(photo_name);
                                 });
                                </script></head>';
                    unset($_POST['uploadImage']);
                }else{
                    $result = 'File not uploaded!';
                }

            }
            return $result;
        }
/*------------------------------------------ END UPLOAD TEMP IMAGE FUNCTION --------------------------------------------------------*/

/************************ ADD BACK SIDE - DOWNLOAD TEMPLATES AJAX ***************************/
    if(isset($_POST['add_back_side'])){
        $tpl_alias = $_POST['alias'];
        $templates = getTemplates($tpl_alias);

        require_once './views/templates.php';

        exit();
    }

    if(isset($_POST['choose_template'])){
        $id = $_POST['id'];
        $template = getTemplate($id);

        echo json_encode($template);

        exit();
    }
/************************ END ADD BACK SIDE - DOWNLOAD TEMPLATES AJAX ***********************/


/*============================= OFFER ORDER ============================== */
function offerOrder(){
    if(isset($_POST['confirm_copy_rights'])){
        if(isset($_POST['wishes'])){

            $save = array();

            $save['wishes'] = $_POST['wishes'];

            $error = '';

            $service = getService($_POST['type']);
            $save['type'] = $service['title'];

            if(!isset($_POST['printing_type'])){
                $error .= '<li>Не выбран тираж</li>';
            }else{
                $save['printing_type'] = getPrintingType($_POST['printing_type']);
                if(!$save['printing_type']) $error .= 'Ошибка!';
            }

            if (!isset($_POST['kolvo'])) {
                $error .= '<li>Не выбрано количество</li>';
            } else {
                $save['tiraj'] = $save['printing_type']['id'];
                $save['kolvo'] = $_POST['kolvo'] != 0 ? (int)abs($_POST['kolvo']) : 1;
            }

            if($service['alias'] == 'vizitki') {
                if (!isset($_POST['paper_type'])) {
                    $error .= '<li>Не выбран тип бумаги</li>';
                } else {
                    $save['paper_type'] = getPaperType((int)abs($_POST['paper_type']));
                }

                if (isset($_POST['EXTRA'])) {
                    $extra = getExtra(0);
                    $extra_price = 0;
                    foreach ($extra as $ext) {
                        if (isset($_POST['EXTRA'][$ext['name']])) {
                            $save['dop_uslugi'] .= $_POST['EXTRA'][$ext['name']] . ',';
                            $extra_price += $save['printing_type']['count'] == 100 ? $ext['price1']*KURS : $ext['price2']*KURS;
                        }
                    }
                } else {
                    $save['dop_uslugi'] = NULL;
                }
            }

            $save['type_side'] = (int)abs($_POST['TMPL']['type_side']);

            if($error == ''){
                unset($_SESSION['error']);
                unset($_SESSION['errors']);

                if($service['alias'] == 'vizitki') {
                    $paper_type_price = $save['printing_type']['count'] == 100 ? $save['paper_type']['price1'] * KURS : $save['paper_type']['price2'] * KURS;
                }else{
                    $paper_type_price = 0;
                    $extra_price = 0;
                }

                $totalSum = (ceil($save['printing_type']['price']*KURS + $paper_type_price + $extra_price) * $save['kolvo']);

                $_SESSION['basket'][] = array(
                    'type' => $save['type'],
                    'tiraj' => $save['tiraj'],
                    'kolvo' => $save['kolvo'],
                    'count' => $save['kolvo'] * $save['printing_type']['count'],
                    'type_sides' => $save['type_side'],
                    'wishes' => $save['wishes'],
                    'paper_type' => $save['paper_type'],
                    'layout' => true,
                    'image_face' => NULL,
                    'image_back' => NULL,
                    'dop_uslugi' => $save['dop_uslugi'],
                    'totalSum' => $totalSum,
                );

                redirectTo('/basket');

            }else{
                setSession('errors', $error);
                redirect();
            }
        }
    }else{
        setSession('error', 'Ошибка!');
        redirect();
    }
}

function offerOrder1(){
        if(isset($_POST['confirm_template'])){

            if(isset($_POST['TMPL'])){
                $save['type_side'] = (int)abs($_POST['TMPL']['type_side']);
                $save['img_out_1'] = $_POST['TMPL']['img_out_1'];
                if( $save['type_side'] == 2)
                    $save['img_out_2'] = $_POST['TMPL']['img_out_2'];
                else
                    $save['img_out_2'] = NULL;

                setSession('TMPL', array(
                    'code' => $_POST['TMPL']['code'],
                    'code1' => $_POST['TMPL']['code1'],
                    'height' => $_POST['TMPL']['height'],
                    'width' => $_POST['TMPL']['width'],
                    'offset' => $_POST['TMPL']['offset'],
                    'type_side' => $save['type_side'],
                    'img_out_1' => $save['img_out_1'],
                    'img_out_2' => $save['img_out_2'],
                ));

            }else{
                $save['type_sides'] = NULL;
                $save['img_out_1'] = NULL;
                $save['img_out_2'] = NULL;
            }
            return $save['type_side'];

        }else{
            setSession('error', 'Ошибка!');
            redirect();
        }
    return true;
}

function offerOrder2(){
    if(isset($_POST['confirm_copy_rights'])){
        if(isset($_POST['wishes'])){

            $save = array();

            $tpl = getSession('TMPL');

            $save['wishes'] = $_POST['wishes'];

            $error = '';

            if(!isset($_POST['printing_type'])){
                $error .= '<li>Не выбран тираж</li>';
            }else{
                $save['printing_type'] = getPrintingType(abs((int)trim($_POST['printing_type'])));
                if(!$save['printing_type']) $error .= 'Ошибка!';
            }

            if(!isset($_POST['paper_type'])){
                $error .= '<li>Не выбран тип бумаги</li>';
            }else{
                $save['paper_type'] = getPaperType(abs((int)$_POST['paper_type']));
            }

            if(!isset($_POST['kolvo'])){
                $error .= '<li>Не выбрано количество</li>';
            }else{
                $save['tiraj'] = $save['printing_type']['id'];
                $save['kolvo'] = $_POST['kolvo'] != 0 ? (int)abs($_POST['kolvo']) : 1;
            }

            if(isset($_POST['EXTRA'])){
                $extra = getExtra(0);
                foreach($extra as $ext){
                    if(isset($_POST['EXTRA'][$ext['name']]))
                        $save['dop_uslugi'] .= $_POST['EXTRA'][$ext['name']].',';
                }
            }else{
                $save['dop_uslugi'] = NULL;
            }

            $save['type'] = 'Визитки';

            $save['type_side'] = (int)abs($tpl['type_side']);
            $save['img_out_1'] = $tpl['img_out_1'];
            if( $save['type_side'] == 2)
                $save['img_out_2'] = $tpl['img_out_2'];
            else
                $save['img_out_2'] = NULL;


            if($error == ''){
                unset($_SESSION['error']);
                unset($_SESSION['errors']);

                $paper_type_price = $save['printing_type']['count'] == 100 ? $save['paper_type']['price1']*KURS : $save['paper_type']['price2']*KURS;

                $totalSum = (ceil($save['printing_type']['price']*KURS + $paper_type_price) * $save['kolvo']);

                $_SESSION['basket'][] = array(
                    'type' => $save['type'],
                    'tiraj' => $save['tiraj'],
                    'kolvo' => $save['kolvo'],
                    'count' => $save['kolvo'] * $save['printing_type']['count'],
                    'type_sides' => $save['type_side'],
                    'wishes' => $save['wishes'],
                    'paper_type' => $save['paper_type'],
                    'layout' => false,
                    'image_face' => $save['img_out_1'],
                    'image_back' => $save['img_out_2'],
                    'dop_uslugi' => $save['dop_uslugi'],
                    'totalSum' => $totalSum,
                );

                redirectTo('/basket');

            }else{
                setSession('errors', $error);
                redirect();
            }
        }
    }else{
        setSession('error', 'Ошибка!');
        redirect();
    }
}
/*==========================================================*/


/*=============== OFFER ORDER ====================== */
function checkAndSaveOrder(){
    $user = getSession('USER');
    if(!$user || $user['temp_user_id']){
        if(!isset($_POST['USER'])) return false;

        if(isset($user['temp_user_id']))
            $temp_user_id = $user['temp_user_id'];
        setSession('USER', array(
                    'name' => $_POST['USER']['name'],
                    'phone' => $_POST['USER']['phone'],
                    'email' => $_POST['USER']['email'],
                    'address' => $_POST['USER']['address'],
                  )
        );
        if(isset($temp_user_id)) $_SESSION['USER']['temp_user_id'] = $temp_user_id;

    }

    $orders = getSession('basket');

    if(!$orders) return false;

    foreach($orders as $order){
        if(!$order_id = saveOrder($order)){
            setSession('error', 'Ошибка сохранения заказа!');
            return false;
        }
        unset($_SESSION['error']);

        if($order['layout']){
            moveLayouts($order_id);
        }
    }
    unset($_SESSION['USER']['temp_user_id']);

    return true;
}
/*==========================================================*/


/*=============== SEND NEW PASSWORD ====================== */
function sendNewPassword($email, $password){

    $configs = getSession('CONFIGS');
    $siteName = $configs['site_name']['value'];

    $to      = $email;
    $subject = 'Восстановление пароля';
    $message = 'Здравствуйте!'. "\r\n" . 'Ваш пароль для входа: ' . $password . "\r\n" .
                'Не забудте поменять пароль в личном кабинете' . "\r\n" .
                'С уважением, администрация сайта '. $siteName;
    $headers = 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    return true;
}
/*======================================================== */



/*=============== TEST IF TEXT PAGE ====================== */
/*if(preg_match_all('/[catalog]{7,}[_]/', $view, $match)){
    $catalogView = $view;
    $view = 'textPage';
};*/
/*==========================================================*/

/*=================================================================================================
-------------------      DOWNLOAD CONTENT FOR VIEWS AND SWITCH FUNCTIONS      ---------------------
===================================================================================================*/


    switch($view){
        // homepage
        case('home'):
            $bigButtonsMenu = getMenu('big_buttons');
            $slider = getSliderImages();
            $services = getServices();
            $services = getServiceTiraj($services);
            $page = getPageContent($view);
            if(!$page){
                $page = '';
            }

        break;

        //registration
        case('register'):
            if(isset($_POST['register_submit'])){
                register();
            }
        break;

        //login
        case('login'):
            if(isset($_POST['auth'])){
                logIn();
            }else{
                redirect();
                exit();
            }
        break;

        //logout
        case('logout'):
            logOut();
        break;

        //forget password
        case('forget_password'):
            if(isset($_POST['send_password'])){
                $email = trim($_POST['email']);
                if($email != ''){
                    $newPassword = substr(uniqid(), 3, 6);
                    if(!saveNewPassword($email, $newPassword)){
                        setSession('error', 'Пользователь с таким емэйлом не найден!');
                        setSession('user_email', $email);
                    }elseif(!sendNewPassword($email, $newPassword)){
                        setSession('error', 'Ошибка отправки сообщения!');
                        setSession('user_email', $email);
                    }
                }else{
                    setSession('error', 'Поле &laquo;Email;&raquo; должно быть заполнено');
                }
            }
        break;


        // trebovanija k maketam
        case('trebovanija_k_maketam'):
            $page = getPageContent($view);
            if(!$page){
                $page = '';
            }
            $view = 'info_page';
        break;
        // trebovanija k maketam
        case('oplata_i_dostavka'):
            $page = getPageContent($view);
            if(!$page){
                $page = '';
            }
            $view = 'info_page';
        break;

        // service page
        case('catalog_service'):
            $bigButtonsMenu = getMenu('big_buttons');
            $service = getService($service_alias);
            $page = getPageContent('catalog_'.$service_alias);
            if(!$page){
                $page['text'] = '<p>Такого товара нет!</p>';
            }

        break;

        // edit templates group list
        case('vizitka_edit_group_list'):
            $bigButtonsMenu = getMenu('big_buttons');
            $group_templates = getGroupTemplates();
            $page = getPageContent($view);
            if(!$page){
                $page = '';
            }
        break;

        // edit template list
        case('vizitka_edit_template_list'):
            $bigButtonsMenu = getMenu('big_buttons');
            $categories = getCategories();
            $newTemplates = getNewTemplates();
            $templates = getTemplates();
            $page = getPageContent($view);
            if(!$page){
                $page = '';
            }
        break;

        // edit template step 1
        case('vizitka_edit_template'):
            $editor = true;
            $bigButtonsMenu = getMenu('big_buttons');
            $tiraj = getTiraj('vizitki');
            $template = getTemplate($id);
            $paper_types = getPaperTypes();
            $page = getPageContent($view);
            if(!$page){
                $page = '';
            }
        break;

        // upload template layout
        case('upload_layout'):
            $editor = true;
            $bigButtonsMenu = getMenu('big_buttons');
            $title = getServiceTitle($layout_alias);
            if(!$title || $title == NULL) setSession('error', 'Database error');
                else unset($_SESSION['error']);
            $tiraj = getTiraj($layout_alias, '1,2');
            if($layout_alias == 'vizitki'){
                $extra = getExtra(0);
                $paper_types = getPaperTypes();
            }

            $layouts = getLayouts();
        break;

        // upload template layout
        case('order_design'):
            $editor = true;
            $title = getServiceTitle($service_alias);
            $tiraj = getTiraj($service_alias, '1,2');
            if($service_alias == 'vizitki') $extra = getExtra(1);
            $paper_types = getPaperTypes();
        break;

        //catalog text page
        case('textPage'):
            $bigButtonsMenu = getMenu('big_buttons');
            $page = getPageContent($catalogView);
            if(!$page){
                $page = '';
            }
            $view = 'textPage';
        break;

        //editor
        case('editor'):
            $editor = true;
            $page = getPageContent($view);
            if(!$page){
                $page = '';
            }
        break;

        // uploadImage
        case('uploadImageToEditor'):
            if(isset($_POST['uploadImage'])){
               echo uploadImage();
            }else{
                redirect();
            }
        break;

        //basket
        case('basket'):
            $dop_uslugi = getExtra('1,0');
            $tiraj = getAllTiraj();
            $layouts = getLayouts();

            if(isset($_POST['index'])){
                $index = (int)$_POST['index'];
                $count = abs((int)$_POST['kolvo']);
                basketRecount($index, $count);
            }

        break;

        //offer
        case('offerOrder'):
            offerOrder();
        break;

        //offer order after 1 step
        case('offerOrder1'):
            $editor = true;
            $type_sides = offerOrder1();
            $bigButtonsMenu = getMenu('big_buttons');
            $tiraj = getTiraj('vizitki', $type_sides);
            $paper_types = getPaperTypes();
            $page = getPageContent($view);
            $view = 'offer_order';
        break;

        //offer order after 2 step
        case('offerOrder2'):
            offerOrder2();
        break;

        //save order
        case('saveOrder'):
            if(!checkAndSaveOrder())
                redirect();
            unset($_SESSION['basket']);
            unset($_SESSION['TMPL']);
            redirectTo('/basket', 'Ваш заказ успешно оформлен. С вами свяжутся в близжайшее время наши администраторы.');
        break;

        // delete item from basket
        case('delete_item_from_basket'):
            deleteItemFromBasket($delete_item_id);
        break;

        default:
            $view = 'home';
    }
/*================================================================================================
-------------------      DOWNLOAD CONTENT FOR VIEWS AND SWITCH FUNCTIONS      --------------------
==================================================================================================*/


// подключени вида
require_once VIEW.'index.php';

