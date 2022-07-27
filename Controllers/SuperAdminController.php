<?php

namespace Controllers;



class SuperAdminController extends Controller
{
    protected function displayBooking()
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

    public function displayBookingAdmin(): array
    {
        $model = new \Models\Model();
        $bookingList = $model -> readBooking();
        $this -> render('super-admin-control',[
            'booking' => $bookingList
        ]);
    }
    
    
}