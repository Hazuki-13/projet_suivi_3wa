<?php

session_start();


date_default_timezone_set('Europe/Paris');


// Autoloader de notre application
spl_autoload_register(function ($className) {
    require str_replace('\\', '/', $className) . '.php'; 
});
;

if(isset($_SESSION['ok']) && ($_SESSION['ok']) == true)
{

    // Récupération de toutes les routes de l'application
    $routes = require 'routesAdmin.php';
    
    // Récupération de la route sur laquelle on se trouve
    $route = $_SERVER['PATH_INFO'] ?? '/home';
    
    if (!isset($routes[$route]))
    {
        header ("location: home");
    };
    
    list($controllerName, $method) = $routes[$route];
    
    
    $controller = new $controllerName();
    $controller->$method();
}
else
{

    
    
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
}



