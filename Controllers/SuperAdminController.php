<?php

namespace Controllers;

use Models\AdminModel;

class SuperAdminController extends Controller
{
    public function displayBooking(): void
    {
        $this -> render ('super-admin-control');
    }

    // public function showRooms(): void
    // {
    //     $model = new \Models\Model();
    //     $roomslist = $model -> getRooms();
    //     $this -> render ('room', [
    //         'rooms' => $roomslist
    //     ]);
    // }
    
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
        $this -> render('super-admin-control',[
            'booking' => $bookingList
        ]);
    }
    
    
}