<?php

namespace Controllers;

use Models\AdminModel;
use Models\BookingModel;
use Models\RoomModel;

class SuperAdminController extends Controller
{
    public function displayBooking(): void
    {
        $this -> render ('super-admin-control');
    }
    
    public function showRooms(): void
    {
        $table = new \Models\RoomModel();
        $roomslist = $table -> getRooms($_GET['rooms']);
        $this -> render('super-admin-control');
        
    }

    public function displayBookingAdmin(): void
    {
        $model = new AdminModel;
        $bookingList = $model -> readBooking();
        // echo'<pre>';
        // var_dump($bookingList);
        // echo '</pre>';
        // die();
        $this -> render('super-admin-control',[
            'booking' => $bookingList
        ]);
    }
}

    
    