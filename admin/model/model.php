<?php defined('VIZITKI') or die('Access denied'); ?>

<?php

/*================================================================*/
/*======================== connect to database ===================*/
/*================================================================*/

$link = mysqli_connect(HOST, USER, PASS) or die('No connect to Server');

mysqli_select_db($link,DB) or die('No connect to DB');
mysqli_query($link,"SET NAMES 'UTF8'") or die('Cant set charset');

/*======================= connect to database  ===========================*/


/*======================= GET ORDERS ===========================*/
    function getOrders(){
        global $link;

        $q = "SELECT * FROM orders ORDER BY id DESC";
        $result = mysqli_query($link, $q);
        if(!$result) return false;

        $orders = array();
        while($row = mysqli_fetch_assoc($result)){
            $orders[] = $row;
        }

        return $orders;
    }
/*======================= GET ORDERS ===========================*/


/*======================= GET USERS FOR ORDERS ===========================*/
    function getUsersForOrders($orders){
        global $link;

        $users_id = array();

        foreach($orders as $order){
            $users_id[] = $order['user_id'];
        }

        $users_id = '('.implode(',', $users_id).')';

        $q = "SELECT id,fio FROM users WHERE id IN $users_id";
        $result = mysqli_query($link, $q);
        if(!$result) return false;

        $users = array();
        while($row = mysqli_fetch_assoc($result)){
            $users[] = $row;
        }

        $user_result = array();

        foreach($users as $user)
            $user_result[$user['id']] = $user['fio'];

        return $user_result;
    }


/*======================= GET USERS FOR ORDERS ===========================*/



/*======================= GET ORDER ===========================*/
function getOrder($id){
    global $link;

    $q = "SELECT * FROM orders WHERE id={$id}";
    $result = mysqli_query($link, $q);
    if(!$result) return false;

    $order = array();
    while($row = mysqli_fetch_assoc($result)){
        $order[] = $row;
    }
    if(count($order) != 1) return false;

    return $order[0];
}
/*======================= GET ORDER ===========================*/


/*======================= EDIT ORDER STATUS===========================*/
function editOrder($id, $status){
    global $link;

    $q = "UPDATE orders SET status='{$status}', updated_at=NOW() WHERE id={$id}";
    $result = mysqli_query($link, $q);
    if(!$result) return false;

    return true;
}
/*======================= EDIT ORDER STATUS ===========================*/


/*======================= GET USER FOR ORDER ===========================*/
function getUserForOrder($id){
    global $link;

    $q = "SELECT * FROM users WHERE id={$id}";
    $result = mysqli_query($link, $q);
    if(!$result) return false;

    $user = array();
    while($row = mysqli_fetch_assoc($result)){
        $user[] = $row;
    }
    if(count($user) != 1) return false;

    return $user[0];
}
/*======================= GET USER FOR ORDER ===========================*/

function getPaperType($id){
    global $link;

    $q = "SELECT id, title, price FROM paper_type WHERE id = '{$id}'";
    $result = mysqli_query($link,$q);
    if(!$result){
        return NULL;
    }

    $paper_type = array();
    while($row = mysqli_fetch_assoc($result)){
        $paper_type[] = $row;
    }

    if(count($paper_type) != 1 ) return false;

    return $paper_type[0];
}

/*============== Get Paper Type ================*/

/*============== Get Tiraj ================*/
function getTiraj($id){
    global $link;

    $q = "SELECT * FROM tiraj_vizitki WHERE id={$id}";
    $result = mysqli_query($link,$q);
    if(!$result){
        return NULL;
    }

    $tiraj = array();
    while($row = mysqli_fetch_assoc($result)){
        $tiraj[] = $row;
    }

    if(count($tiraj) != 1) return false;

    return $tiraj[0];
}

/*============== Get Tiraj ================*/


/*============== DELETE ORDER ================*/
function deleteOrder($id){
    global $link;

    $q = "DELETE FROM orders WHERE id={$id}";
    $result = mysqli_query($link,$q);
    if(!$result){
        return false;
    }
    return true;
}

/*============== DELETE ORDER ================*/


/*============== DELETE GROUP|SERVICE ================*/
function deleteGroup($id){
    global $link;

    $group = getAdminService($id);
    /*$q = "DELETE FROM services WHERE id={$id}";
    $result = mysqli_query($link,$q);
    if(!$result){
        return false;
    }*/

    $images = array(
        'image' => $group['image'],
        'image_hover' => $group['image_hover'],
    );

    return $images;
}

/*============== DELETE GROUP|SERVICE ================*/



/*============== GET GROUPS|SERVICES ================*/
function getAdminServices(){
    global $link;

    $q = "SELECT * FROM services ORDER BY `position` ASC";
    $result = mysqli_query($link, $q);
    if(!$result) return false;

    $services = array();
    while($row = mysqli_fetch_assoc($result)){
        $services[] = $row;
    }

    return $services;
}

/*============== GET GROUPS|SERVICES ================*/


/*============== GET GROUP|SERVICE ================*/
function getAdminService($id){
    global $link;

    $q = "SELECT * FROM services WHERE id={$id}";
    $result = mysqli_query($link,$q);
    if(!$result){
        return NULL;
    }

    $service = array();
    while($row = mysqli_fetch_assoc($result)){
        $service[] = $row;
    }

    if(count($service) != 1) return false;

    return $service[0];
}

/*============== GET GROUP|SERVICE ================*/


/*============== GET GROUP|SERVICE DESCRIPTION ================*/
function getGroupDescription($alias){
    global $link;

    $q = "SELECT * FROM page WHERE name='{$alias}'";
    $result = mysqli_query($link,$q);
    if(!$result){
        return NULL;
    }

    $groupDescription = array();
    while($row = mysqli_fetch_assoc($result)){
        $groupDescription[] = $row;
    }
    if(count($groupDescription) > 1) return false;

    return $groupDescription[0];
}

/*============== GET GROUP|SERVICE DESCRIPTION ================*/



/*============== CHECK GROUP|SERVICE ALIAS ================*/
function checkServiceAlias($alias){
    global $link;

    $i = 1;
    $q = "SELECT id FROM services WHERE alias='{$alias}'";
    $result = mysqli_query($link,$q);
    $res = array();
    while($row = mysqli_fetch_assoc($result)){
        $res[] = $row;
    }
    if(count($res) > 0){
        $alias = $alias.'_'.$i;
        checkServiceAlias($alias);
        $i++;
    }

    return $alias;
}

/*============== CHECK GROUP|SERVICE ALIAS ================*/


/*============== SAVE|EDIT GROUP|SERVICE ================*/
function saveEditedService($group){
    global $link;

    $q = "UPDATE services SET `image` = '" . mysqli_real_escape_string($link, $group['image']) . "',
                              `image_hover` = '" . mysqli_real_escape_string($link, $group['imageHover']) . "',
                              `title` = '" . mysqli_real_escape_string($link, $group['title']) . "',
                              `alias` = '" . mysqli_real_escape_string($link, $group['newalias']) . "',
                              `size` = '" . mysqli_real_escape_string($link, $group['size']) . "',
                              `is_active` = {$group['is_active']}
                          WHERE id = {$group['id']}";
    $result = mysqli_query($link,$q) or die($q . '<br/>' .mysqli_error($link));
    if(!$result){
        return false;
    }

    $q = "UPDATE page SET `h1` = '" . mysqli_real_escape_string($link, $group['pageH1']) . "',
                          `name` = '" . mysqli_real_escape_string($link, $group['pageAlias']) . "',
                          `title` = '" . mysqli_real_escape_string($link, $group['pageTitle']) . "',
                          `keywords` = '" . mysqli_real_escape_string($link, $group['pageKeywords']) . "',
                          `description` = '" . mysqli_real_escape_string($link, $group['pageDescription']) . "',
                          `text` = '" . mysqli_real_escape_string($link, $group['pageText']) . "'
                      WHERE `name` = 'catalog_{$group['alias']}'";
    $result = mysqli_query($link,$q) or die($q . '<br/>' .mysqli_error($link));
    if(!$result){
        return false;
    }

    return true;
}

/*============== SAVE|EDIT GROUP|SERVICE ================*/


/*============== SAVE|EDIT GROUP|SERVICE ================*/
function saveAddedService($group){
    global $link;

    $maxPos = mysqli_query($link,'SELECT MAX(position) as position FROM services');
    $maxPos = mysqli_fetch_assoc($maxPos);
    $position = $maxPos['position'] + 1;

    $q = "INSERT INTO services (`image`, `image_hover`, `alias`, `title`, `size`, `position`, `is_active`)
                      VALUES ('" . mysqli_real_escape_string($link, $group['image']) . "',
                              '" . mysqli_real_escape_string($link, $group['imageHover']) . "',
                              '" . mysqli_real_escape_string($link, $group['alias']) . "',
                              '" . mysqli_real_escape_string($link, $group['title']) . "',
                              '" . mysqli_real_escape_string($link, $group['size']) . "',
                              {$position},
                              " . mysqli_real_escape_string($link, $group['is_active']) . "
                          )";
    $result = mysqli_query($link,$q) or die($q . '<br/>' .mysqli_error($link));
    if(!$result){
        return false;
    }

    $q = "INSERT INTO page (`name`, `h1`, `title`, `keywords`, `description`, `text`)
                      VALUES ('" . mysqli_real_escape_string($link, $group['pageAlias']) . "',
                          '" . mysqli_real_escape_string($link, $group['pageH1']) . "',
                          '" . mysqli_real_escape_string($link, $group['pageTitle']) . "',
                          '" . mysqli_real_escape_string($link, $group['pageKeywords']) . "',
                          '" . mysqli_real_escape_string($link, $group['pageDescription']) . "',
                          '" . mysqli_real_escape_string($link, $group['pageText']) . "'
                        )";
    $result = mysqli_query($link,$q) or die($q . '<br/>' .mysqli_error($link));
    if(!$result){
        return false;
    }

    return true;
}

/*============== SAVE|EDIT GROUP|SERVICE ================*/





