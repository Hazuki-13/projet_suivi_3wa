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

    // public function update() :void
    // {
    //     $id = $_GET['id'];
    //     $data = [
    //         $_POST['firstName'],
    //         $_POST['lastName'],
    //         $_POST['birthDate'],
    //         $_POST['email']
    //     ];
        
    //     echo('<pre>');
    //     print_r($data);
    //     echo ('</pre>');
        
    //     // $model -> newBooking($data);
    //     $model = new AdminModel;
    //     $model -> updateModelCustomers($data, $id);

    //     // on vient d'inserer des element new customer
    //     // recuperer l'id de ce nouveau customer
    //     // $cust_id = $model -> getLastCustomerId();
        
    //     $modelRoom = new RoomModel();
    //     $rooms = $modelRoom -> getRooms(['cat_title']);
        
    //     $dataSuite = [
    //         // $cust_id,
    //         $_POST['cat_id'],
    //         $_POST['check_in'],
    //         $_POST['check_out']
    //     ];
        
    //     echo('<pre>');
    //     print_r($dataSuite);
    //     echo ('</pre>');
    //     die();
        
    //     // $model -> updateModelCustomers($id, $data);
    //     // $model2 -> newBookingSuite($dataSuite);
        
    //     $model2 = new AdminModel;
    //     $model2 -> updateModelBooking($dataSuite, $id);


        // $modelcustomers = new AdminModel();
        // $data = [
        //     $_POST ['firstname'],
        //     $_POST ['lastname'],
        //     $_POST ['birthDate'],
        //     $_POST ['email']
        // ];
        // $modelBooking = new AdminModel();
        // $dataSuite = [
        //     $_POST ['cat_id'],
        //     $_POST ['check_in'],
        //     $_POST ['check_out']
        // ];
        // echo'<pre>';
        // var_dump($_GET);
        // echo '</pre>';
        // die();
        
        // $modelRoom = new \Models\RoomModel();
        // $rooms = $modelRoom -> getRooms(['cat_title']);
        // $modelcustomers -> updateModelCustomers($id, $data);
        // $modelBooking -> updateModelCustomers($id, $dataSuite);

    //     redirect('/super-admin-control');

    // }
        

    // public function delete() :void
    // {
    //     $id = $_GET['id'];
    //     // echo'<pre>';
    //     // var_dump($_GET);
    //     // echo '</pre>';
    //     // die();
    //     $model = new BookingModel();
    //     $model -> deleteModel($id);
    //     redirect('/super-admin-control');
    // }
}

    
    