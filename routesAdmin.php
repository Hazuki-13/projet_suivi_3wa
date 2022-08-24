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

    '/logout' => [
        'Controllers\LoginController',
        'logout'
    ],
    
    '/login/access' => [
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
    ],
    
    '/super-admin-control' => [
        'Controllers\SuperAdminController',
        'displayBookingAdmin'
    ],
    
    '/super-admin-control/updateBooking' => [
        'Controllers\BookingController',
        'edit'
    ],
    
    '/super-admin-control/update' => [
        'Controllers\BookingController',
        'update'
    ],
    
    '/addAdmin' => [
        'Controllers\SuperAdminController',
        'displayAddAdmin'
    ],
    
    '/addAdmin/create' => [
        'Controllers\SuperAdminController',
        'createNewAdmin'
    ],
    
    '/users' => [
        'Controllers\SuperAdminController',
        'displayUsers'
    ],
    
    '/users/updateAdmin' => [
        'Controllers\SuperAdminController',
        'edit'
    ],
    
    '/users/update' => [
        'Controllers\SuperAdminController',
        'update'
    ],
    
    '/users/delete' => [
        'Controllers\SuperAdminController',
        'delete'
    ],
    
    '/super-admin-control/delete' => [
        'Controllers\BookingController',
        'delete'
        ]
        
    ];
    
    