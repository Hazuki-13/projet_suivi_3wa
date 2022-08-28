<?php

session_start();

// fuseau horaire de l'application
date_default_timezone_set('Europe/Paris');


// Autoloader de l'application
spl_autoload_register(function ($className) {
    require str_replace('\\', '/', $className) . '.php'; 
});
;

//condition si $_SESSION est defini et que $_SESSION = true alors l'accès aux routes admin est permis
if(isset($_SESSION['ok']) && ($_SESSION['ok']) == true)
{

    // Récupération de toutes les routes admin
    $routes = require 'routesAdmin.php';
    
    // Récupération de la route sur laquelle on se trouve
    $route = $_SERVER['PATH_INFO'] ?? '/home';

    //si $routes n'est pas defini alors direction page home par defaut
    if (!isset($routes[$route]))
    {
        header ("location: home");
    };
    
    //récupération du controlleur et de sa méthode
    list($controllerName, $method) = $routes[$route];

    //instanciation du controller
    $controller = new $controllerName();
    $controller->$method();
}
// sinon accès aux routes publique uniquement
else
{
    //récupération des routes publique
    $routes = require 'routes.php';
    
    // Récupération de la route sur laquelle on se trouve
    $route = $_SERVER['PATH_INFO'] ?? '/home';
    
    //si $routes n'est pas defini alors direction page home par defaut
    if (!isset($routes[$route]))
    {
        header ("location: home");
    };
    
    //récupération du controlleur et de sa méthode
    list($controllerName, $method) = $routes[$route];
    
    //instanciation du controller
    $controller = new $controllerName();
    $controller->$method();
}

    
    



