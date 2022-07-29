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
        // echo'<pre>';
        // var_dump($bookingList);
        // echo '</pre>';
        // die();
        $this -> render('super-admin-control',[
            'booking' => $bookingList
        ]);
    }

    public function update() :void
    {
        $id = $_GET['id'];
        // echo'<pre>';
        // var_dump($_GET);
        // echo '</pre>';
        // die();
        $model = new AdminModel();
        $model -> updateModel($id);
        redirect('/super-admin-control');

    }

    public function delete() :void
    {
        $id = $_GET['id'];
        // echo'<pre>';
        // var_dump($_GET);
        // echo '</pre>';
        // die();
        $model = new AdminModel();
        $model -> deleteModel($id);
        redirect('/super-admin-control');

    }
    
    
}