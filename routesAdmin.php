<?php

/**
* Construit une url absolue à partir d'un chemin
* 
* @param string $path
* @param array $parameters
* @return string
*/
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

// toutes les routes publique et admin avec leur méthodes
return [
    '/home' => [
        'Controllers\HomeController',
        'displayHome'
    ],

    '/logout' => [
        'Controllers\LoginController',
        'logout'
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
    
    '/bookingList' => [
        'Controllers\AdminController',
        'displayBookingAdmin'
    ],
    
    '/bookingList/updateBooking' => [
        'Controllers\BookingController',
        'edit'
    ],
    
    '/bookingList/update' => [
        'Controllers\BookingController',
        'update'
    ],
    
    '/bookingList/delete' => [
        'Controllers\BookingController',
        'delete'
    ],
    
    '/addAdmin' => [
        'Controllers\AdminController',
        'displayAddAdmin'
    ],
    
    '/addAdmin/create' => [
        'Controllers\AdminController',
        'createNewAdmin'
    ],
    
    '/users' => [
        'Controllers\AdminController',
        'displayUsers'
    ],
    
    '/users/updateAdmin' => [
        'Controllers\AdminController',
        'edit'
    ],
    
    '/users/update' => [
        'Controllers\AdminController',
        'update'
    ],
    
    '/users/delete' => [
        'Controllers\AdminController',
        'delete'
    ]
        
    ];
    
    