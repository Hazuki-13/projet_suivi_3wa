<?php

// /**
//  * Construit une url absolue à partir d'un chemin
//  * 
//  * @param string $path
//  * @param array $parameters
//  * @return string
//  */
function url(string $path, array $parameters = []): string 
{
    $url = $_SERVER['SCRIPT_NAME'] . $path;
    
    if (! empty($parameters)) {
        $url .= "?" . http_build_query($parameters);
    }
    
    return $url;
}

/**
 * Redirige vers une route de l'application
 * 
 * @param string $path
 * @param array $parameters
 */
function redirect(string $path, array $parameters = []): void
{
    header('Location: ' . url($path, $parameters));
    exit();
}

return [
    '/home' => [
        'Controllers\HomeController',
        'displayHome'
    ],
    
    '/login' => [
        'Controllers\LoginController',
        'displayLogin'
    ],

    '/room' => [
        'Controllers\HomeController',
        'displayRoom'
    ],

    '/buffet' => [
        'Controllers\HomeController',
        'displayBuffet'
    ],

    '/booking' => [
        'Controllers\BookingController',
        'booking'
    ],

    '/super-admin-control' => [
        'Controllers\FullController',
        'displayControl'
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

