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

    // public function login()
    // {

    // }

    // public function addAdmin()
    // {
    //     $error = false;
    //     $errorUserName = '';
    //     $errorEmail='';
    //     $errorPassword='';
    //     $errorConfirmPassword='';

    //     if(!isset($_POST['userName']) || (isset($_POST['userName']) && empty($_POST['userName']))) 
    //     {
    //         $errorFirstName = 'username input empty';
    //         $error = true;
    //     }
        
    //     if(!isset($_POST['email']) || (isset($_POST['email']) && empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))) 
    //     {
    //         $errorEmail= 'email invalid';
    //         $error = true;         
    //     }
                    
    //     if(!isset($_POST['password']) || (isset($_POST['password']) && empty($_POST['password']))) 
    //     {
    //         $errorLastName = 'password incorrect';
    //         $error = true;         
    //     }

    //     if(!isset($_POST['confirmPassword']) || (isset($_POST['confirmPassword']) && empty($_POST['confirmPassword']))) 
    //     {
    //         $errorLastName = 'Password incorrect';
    //         $error = true;         
    //     }

    //     $_SESSION['message']=[
    //         'userName'=> $errorUserName,
    //         'email'  => $errorEmail,
    //         'password'  => $errorPassword,
    //         'confirmPassword'  => $errorConfirmPassword
    //     ];

    //     if($error)
    //     {
    //        $_SESSION["data"] = [
    //         'userName'=> htmlspecialchars($_POST['userName']),
    //         'email'  => htmlspecialchars($_POST['email']),
    //         'password'  => htmlspecialchars($_POST['password']),
    //         'confirmPassword' => htmlspecialchars($_POST['confirmPassword'])
    //        ];

    //     }
    // }
}

    
    