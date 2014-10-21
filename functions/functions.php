<?php defined('VIZITKI') or die('Access denied'); ?>

<?php

// print array
function print_arr($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
// print array die
function dprint_arr($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    die;
}
// var_dump die
function dd($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die;
}

// echo $var die
function ed($var){
    echo $var; die;
}

// redirect
function redirect(){
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}

// redirect To
function redirectTo($url, $message=null){

    setSession('success', $message);
    header("Location: ".PATH.$url);
    exit;
}


function setSession($name, $value){
    $_SESSION[$name] = $value;
    return true;
}

function getSession($name){
    if(!isset($_SESSION[$name])){
        return false;
    }
    return $_SESSION[$name];
}

function deleteItemFromBasket($id){
    unset($_SESSION['basket'][$id]);
    $_SESSION['basket'] = array_values($_SESSION['basket']);
    redirect();
}

function createSessionUser(){
    $d = date('d');
    $m = date('m');
    $y = date('Y');
    $h = date('H');
    $i = date('i');
    $s = date('s');

    $id = (int)$d . (int)$m . (int)$y . (int)$h . (int)$i . (int)$s;

    $_SESSION['USER']['temp_user_id'] = $id;

    return $id;
}

function moveLayouts($order_id){
    $user = getSession('USER');
    if(isset($user['temp_user_id'])){
        $source = 'uploads/_tmp/'.$user['temp_user_id'].'/';
    }else{
        $source = 'uploads/_tmp/'.$user['user_id'].'/';
    }

    mkdir('uploads/orders/'.$order_id);
    $destination = 'uploads/orders/'.$order_id.'/';

    $files = scandir($source);
    foreach($files as $file){
        rename($source.$file, $destination.$file);
    }
    rmdir($source);

    return true;

}

function removeOrderLayouts($id){
    $dir = 'uploads/orders/'.$id;

    if(file_exists($dir)){

        $files = scandir($dir.'/');
        foreach($files as $file){
            unlink($dir.'/'.$file);
        }
        rmdir($dir);
    }

    return true;
}

function removeGroupLayouts($images){
    $dir = 'uploads/services/';

        unlink($dir.$images['image']);
        unlink($dir.$images['image_hover']);

        print_r($images);
        ed($dir.$images['image']);

    return true;
}

function rus2translit($string) {

    $converter = array(

        'а' => 'a',   'б' => 'b',   'в' => 'v',

        'г' => 'g',   'д' => 'd',   'е' => 'e',

        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',

        'и' => 'i',   'й' => 'y',   'к' => 'k',

        'л' => 'l',   'м' => 'm',   'н' => 'n',

        'о' => 'o',   'п' => 'p',   'р' => 'r',

        'с' => 's',   'т' => 't',   'у' => 'u',

        'ф' => 'f',   'х' => 'h',   'ц' => 'c',

        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',

        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',

        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',



        'А' => 'A',   'Б' => 'B',   'В' => 'V',

        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',

        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',

        'И' => 'I',   'Й' => 'Y',   'К' => 'K',

        'Л' => 'L',   'М' => 'M',   'Н' => 'N',

        'О' => 'O',   'П' => 'P',   'Р' => 'R',

        'С' => 'S',   'Т' => 'T',   'У' => 'U',

        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',

        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',

        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',

        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',

    );

    return strtr($string, $converter);

}

function str2url($str) {

    // переводим в транслит

    $str = rus2translit($str);

    // в нижний регистр

    $str = strtolower($str);

    // заменям все ненужное нам на "-"

    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);

    // удаляем начальные и конечные '-'

    $str = trim($str, "-");

    return $str;

}
