<?php 

$avalaibleRoutes = ['home', 'create', 'article'];

$route = 'home';

if (isset($_GET['page']) and in_array($_GET['page'], $avalaibleRoutes)) {
    $route = $_GET['page'];
}

require './views/layout.phtml';