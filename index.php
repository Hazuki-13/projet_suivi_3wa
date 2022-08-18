<?php

session_start();
$_SESSION = [
    'data' => true,
    'user' => false
];

    echo'<pre>';
    var_dump($_SESSION['data']);
    echo '</pre>';
    echo'<pre>';
    var_dump($_SESSION['user']);
    echo '</pre>';
    // // die();

date_default_timezone_set('Europe/Paris');


// Autoloader de notre application
spl_autoload_register(function ($className) {
    require str_replace('\\', '/', $className) . '.php'; 
});


// $home = new Controllers\HomeController();
// $home -> view();

// Récupération de toutes les routes de l'application
$routes = require 'routes.php';
    
// Récupération de la route sur laquelle on se trouve
$route = $_SERVER['PATH_INFO'] ?? '/home';

if (!isset($routes[$route]))
{
    header ("location: home");
};

list($controllerName, $method) = $routes[$route];


$controller = new $controllerName();
$controller->$method();



