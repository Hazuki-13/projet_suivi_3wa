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
        'Controllers\RoomController',
        'displayRooms'
    ],

    '/buffet' => [
        'Controllers\HomeController',
        'displayBuffet'
    ],

    '/booking' => [
        'Controllers\BookingController',
        'bookingFormUser'
    ],

    '/super-admin-control' => [
        'Controllers\SuperAdminController',
        'displayBookingAdmin'
    ],
    
    '/booking/create' => [
        'Controllers\BookingController',
        'create'
    ],
    
    '/booking/ajax' => [
        'Controllers\BookingController',
        'search'
    ],

    '/super-admin-control/update' => [
        'Controllers\SuperAdminController',
        'update'
    ],

    '/super-admin-control/delete' => [
        'Controllers\SuperAdminController',
        'delete'
    ]

];

