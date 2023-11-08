<?php 
date_default_timezone_set('Europe/Paris');

$avalaibleRoutes = ['home', 'create', 'article'];

$route = 'home';

if (isset($_GET['page']) and in_array($_GET['page'], $avalaibleRoutes)) {
    $route = $_GET['page'];
    if($route === 'article' and !isset($_GET['id'])) {
        $route = 'home';
    } elseif ($route === 'article' and isset($_GET['id'])) {
        $route = 'article';
        $post_id = $_GET['id'];
    }
}

require './views/layout.phtml';