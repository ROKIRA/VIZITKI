<?php defined('VIZITKI') or die('Access denied'); ?>

<?php

#    $url = $_SERVER['REQUEST_URI'];

/*echo 'url= '.*/

$url = str_replace('/test/vizitki', '', $_SERVER['REQUEST_URI']);

// echo '<br><hr>';


$routes = array(
    array('url' => '', 'view' => 'home'),
    array('url' => '/', 'view' => 'home'),
    array('url' => '/registration', 'view' => 'register'),
    array('url' => '/login', 'view' => 'login'),
    array('url' => '/logout', 'view' => 'logout'),

    array('url' => '/trebovanija_k_maketam', 'view' => 'trebovanija_k_maketam'),
    array('url' => '/guestbook', 'view' => 'guestbook'),
    array('url' => '/oplata_i_dostavka', 'view' => 'oplata_i_dostavka'),
    array('url' => '/contact', 'view' => 'contact'),

    array('url' => '#^/catalog/service/(?P<service_alias>[a-z0-9-]+)/?$#i', 'view' => 'catalog_service'),

    array('url' => '/catalog/edit-template-vizitki/', 'view' => 'vizitka_edit_group_list'),
    array('url' => '#^/catalog/edit-template-vizitki/(?P<alias>[a-z0-9-]+)/?$#i', 'view' => 'vizitka_edit_template_list'),
    array('url' => '#^/catalog/edit-template-vizitki/([a-z0-9-]+)/(?P<id>\d+)#i', 'view' => 'vizitka_edit_template'),
	
	array('url' => '#^/catalog/upload-layout/(?P<layout_alias>[a-z0-9-]+)/?$#i', 'view' => 'upload_layout'),


    array('url' => '/editor', 'view' => 'editor'),
    array('url' => '/upload-image', 'view' => 'uploadImageToEditor'),

    array('url' => '/offer/order', 'view' => 'offerOrder'),
    array('url' => '/offer/order1', 'view' => 'offerOrder1'),
    array('url' => '/offer/order2', 'view' => 'offerOrder2'),
    array('url' => '/save/order', 'view' => 'saveOrder'),

    array('url' => '/basket', 'view' => 'basket'),
    array('url' => '#^/basket/delete/(?P<delete_item_id>\d+)#i', 'view' => 'delete_item_from_basket'),


    /********************
        ADMIN PANEL
     ********************/
    array('url' => '#/admin/auth/?$#', 'view' => 'auth'),
    array('url' => '#/admin/logout/?$#', 'view' => 'admin_logout'),

    array('url' => '#/admin/?$#', 'view' => 'admin_orders'),
    array('url' => '#^/admin/order/(?P<order_id>[0-9-]+)/?$#i', 'view' => 'admin_order'),
    array('url' => '#^/admin/delete-order/?$#i', 'view' => 'admin_del_order'),

    array('url' => '#^/admin/catalog/(?P<catalog_alias>[a-z0-9_]+)/?$#i', 'view' => 'admin_catalog'),
    array('url' => '#^/admin/catalog/(?P<catalog_alias>[a-z0-9_]+)/(?P<item_id>\d+)/?$#i', 'view' => 'admin_catalog_item'),

);



$error404 = true;
foreach($routes as $route){
    if(preg_match($route['url'], $url, $match) || $route['url'] == $url){
        if(empty($match)){
            $view = $route['view'];
        }else{
            extract($match);
            // $alias - vizitka template alias
            // $service_alias - text page about service
            // $id - vizitka template id
            // $delete_item_id
            // $order_id
            // $catalog_alias
            // $catalog_alias|$item_id

            $view = $route['view'];
        }
        $error404 = false;
        break;
    }
}


if($error404){
    include VIEW.'error404.php';
    exit();
}