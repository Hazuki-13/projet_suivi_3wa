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

    public function displayAddAdmin()
    {
        // $template =  'login' ;
        // require 'MVC/Views/layout.phtml';
        // la methode render remplace le code précedent

        $this -> render('addAdmin');
        
    }

    public function createNewAdmin()
    {
        $error = false;
        $errorUserName = '';
        $errorUserStatus = '';
        $errorEmail='';
        $errorPassword='';
        $errorConfirmPassword='';

        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        if(!isset($_POST['userName']) || (isset($_POST['userName']) && empty($_POST['userName']))) 
        {
            $errorFirstName = 'username input empty';
            $error = true;
        }

        if(!isset($_POST['userStatus']) || (isset($_POST['userStatus']) && empty($_POST['userStatus']))) 
        {
            $errorFirstName = 'userStatus not selected';
            $error = true;
        }
        
        if(!isset($_POST['email']) || (isset($_POST['email']) && empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))) 
        {
            $errorEmail= 'email invalid';
            $error = true;         
        }
                    
        if(!isset($_POST['password']) || (isset($_POST['password']) && empty($_POST['password']))) 
        {
            $errorLastName = 'password incorrect';
            $error = true;         
        }

        if(!isset($_POST['confirmPassword']) || (isset($_POST['confirmPassword']) && empty($_POST['confirmPassword'])) || ($_POST['confirmPassword'] !== ($_POST['password']))) 
        {
            $errorLastName = 'password incorrect';
            $error = true;         
        }

        $errors['message']=[
            'userName'=> $errorUserName,
            'userStatus'=> $errorUserStatus,
            'email'  => $errorEmail,
            'password'  => $errorPassword,
            'confirmPassword'  => $errorConfirmPassword
        ];

        if($error == true)
        {
           $errors["data"] = [
            'userName'=> htmlspecialchars($_POST['userName']),
            'userStatus'=> htmlspecialchars($_POST['userStatus']),
            'email'  => htmlspecialchars($_POST['email']),
            'password'  => htmlspecialchars($_POST['password']),
            'confirmPassword' => htmlspecialchars($_POST['confirmPassword'])
           ];

           $this -> render('addAdmin', [
            'errors' => $errors
            ]);

        }
        else{
            $model = new AdminModel;
            $data = [
               htmlspecialchars($_POST['userName']),
               htmlspecialchars($_POST['userStatus']),
               htmlspecialchars($_POST['email']),
               htmlspecialchars($_POST[$password]),
               
            //    htmlspecialchars($_POST['confirmPassword'])
            ];

            $model -> newAdmin($data);

            redirect('/super-admin-control');
        }
    }

        public function displayUsers(): void
        {
            $model = new AdminModel;
            $userList = $model -> users();
            $this -> render('users', [
                'users' => $userList
            ]);
        }
}

    
    