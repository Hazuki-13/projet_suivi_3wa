<?php

/**
* Construit une url absolue à partir d'un chemin
* 
* @param string $path
* @param array $parameters
* @return string
**/
function url(string $path, array $parameters = []): string 
{
    $url = $_SERVER['SCRIPT_NAME'] . $path;
    
    if (! empty($parameters)) {
        $url .= "?" . http_build_query($parameters);
    }
    
    return $url;
}

/**
* Redirige vers une route
* 
* @param string $path
* @param array $parameters
*/
function redirect(string $path, array $parameters = []): void
{
    header('Location: ' . url($path, $parameters));
    exit();
}

//toutes les routes avec leur méthode coté publique + routes pour accéder à la connexion admin
return [
    '/home' => [
        'Controllers\HomeController',
        'displayHome'
    ],
    
    '/478845ZrqQifzZ9ymRHF_login' => [
        'Controllers\LoginController',
        'displayLogin'
    ],
    
    '/478845ZrqQifzZ9ymRHF_login/access' => [
        'Controllers\LoginController',
        'loginAccess'
    ],
    
    '/room' => [
        'Controllers\RoomController',
        'displayRooms'
    ],
    
    '/booking' => [
        'Controllers\BookingController',
        'bookingFormUser'
    ],
    
    
    '/booking/create' => [
        'Controllers\BookingController',
        'create'
    ],
    
    '/booking/ajax' => [
        'Controllers\BookingController',
        'search'
    ]
        
    ];
    
    