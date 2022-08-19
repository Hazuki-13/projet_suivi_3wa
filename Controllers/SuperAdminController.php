<?php

namespace Controllers;

use Models\AdminModel;
use Models\BookingModel;
use Models\RoomModel;

class SuperAdminController extends Controller
{
    // public function isConnected(): void
    // {
    //     if($_SESSION == true)
    //     {
    //         $this -> render ('super-admin-control');
    //     }
    //     else{
    //         $this -> render ('login');
    //     }
    // }

    
    public function showRooms(): void
    {
        $table = new \Models\RoomModel();
        $roomslist = $table -> getRooms($_GET['rooms']);
        $this -> render('super-admin-control');
        
    }

    public function displayBookingAdmin(): void
    {
        if($_SESSION == true)
        {
            // echo'<pre>';
            // print_r($_SESSION);
            // echo '</pre>';
            // die();

            $model = new AdminModel;
            $bookingList = $model -> readBooking();
            $this -> render('super-admin-control',[
                'booking' => $bookingList
            ]);


        }
        else{
            $this -> render ('login');
        }
        // $model = new AdminModel;
        // $bookingList = $model -> readBooking();
        // // echo'<pre>';
        // // var_dump($bookingList);
        // // echo '</pre>';
        // // die();
        // $this -> render('super-admin-control',[
        //     'booking' => $bookingList
        // ]);
    }

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

    //     if(!isset($_POST['confirmPassword']) || (isset($_POST['confirmPassword']) && empty($_POST['confirmPassword'])) || isset($_POST['confirmPassword'] !== ($_POST['password']))) 
    //     {
    //         $errorLastName = 'password incorrect';
    //         $error = true;         
    //     }

    //     $errors['message']=[
    //         'userName'=> $errorUserName,
    //         'email'  => $errorEmail,
    //         'password'  => $errorPassword,
    //         'confirmPassword'  => $errorConfirmPassword
    //     ];

    //     if($error)
    //     {
    //        $errors["data"] = [
    //         'userName'=> htmlspecialchars($_POST['userName']),
    //         'email'  => htmlspecialchars($_POST['email']),
    //         'password'  => htmlspecialchars($_POST['password']),
    //         'confirmPassword' => htmlspecialchars($_POST['confirmPassword'])
    //        ];

    //     }
    // }
}

    
    