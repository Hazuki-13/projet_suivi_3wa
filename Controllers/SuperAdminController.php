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
        $errorEmail ='';
        $errorPassword ='';
        $errorConfirmPassword ='';

        
        if(!isset($_POST['userName']) || (isset($_POST['userName']) && empty($_POST['userName']))) 
        {
            $errorUserName = 'username input empty';
            $error = true;
        }
        
        if(!isset($_POST['userStatus']) || (isset($_POST['userStatus']) && empty($_POST['userStatus']))) 
        {
            $errorUserStatus = 'user status not selected';
            $error = true;
        }
        
        if(!isset($_POST['email']) || (isset($_POST['email']) && empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))) 
        {
            $errorEmail= 'email invalid';
            $error = true;         
        }
        
        if(!isset($_POST['password']) || (isset($_POST['password']) && empty($_POST['password'])))
        {
            $errorPassword = 'password incorrect';
            $error = true;         
        }
        
        if(!isset($_POST['confirmPassword']) || (isset($_POST['confirmPassword']) && empty($_POST['confirmPassword'])) || ($_POST['confirmPassword'] !== ($_POST['password']))) 
        {
            $errorConfirmPassword = 'password incorrect';
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
        
        //tableau assoc : $variable
        // la clé ['password']
        // pour acceder à une valeur stocker dans un tableau associatif
        // je dois renseigner le tableau dans lequel je dois aller chercher la valeur
        // et je dois renseigner la clé à laquelle est stocker la valeur
        //    $variable = [
            //     'password' => $password
            //     ];
            
            //     $variable['password'];
            
            //     echo('<pre>');
            //     print_r($password);
            //     echo ('</pre>');
            // echo('<pre>');
            // print_r($_SESSION['user']['id']);
            // echo ('</pre>');
            // die();
            
            $this -> render('addAdmin', [
                'errors' => $errors
            ]);
            
        }
        else
        {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $model = new AdminModel;
            $data = [
                htmlspecialchars($_POST['userName']),
                htmlspecialchars($_POST['userStatus']),
                htmlspecialchars($_POST['email']),
                htmlspecialchars($password)
                
                //    htmlspecialchars($_POST['confirmPassword'])
            ];

            $model -> newAdmin($data);

            redirect('/users');
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

        public function edit(): void
        {

            //pour faire afficher le formulaire pour l'UPDATE
            //id du
            $userId = $_GET['user_id'];

            $editModel = new AdminModel();
            $user = $editModel -> userById($userId);
            
            // echo('<pre>');
            // print_r($password);
            // echo ('</pre>');
            // echo('<pre>');
            // print_r($form2);
            // echo ('</pre>');
            // die();
            
            $this -> render('updateAdmin', [
                'user' => $user
            ]);
        }

        public function update()
        {
            $error = false;
            $errorUserName = '';
            $errorUserStatus = '';
            $errorEmail ='';
            $errorPassword ='';
            $errorConfirmPassword ='';

            
            if(!isset($_POST['userName']) || (isset($_POST['userName']) && empty($_POST['userName']))) 
            {
                $errorUserName = 'username input empty';
                $error = true;
            }
            
            if(!isset($_POST['userStatus']) || (isset($_POST['userStatus']) && empty($_POST['userStatus']))) 
            {
                $errorUserStatus = 'userStatus not selected';
                $error = true;
            }
            
            if(!isset($_POST['email']) || (isset($_POST['email']) && empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))) 
            {
                $errorEmail= 'email invalid';
                $error = true;         
            }
            
            if(!isset($_POST['password']) || (isset($_POST['password']) && empty($_POST['password']))) 
            {
                $errorPassword = 'password incorrect';
                $error = true;         
            }
            
            if(!isset($_POST['confirmPassword']) || (isset($_POST['confirmPassword']) && empty($_POST['confirmPassword'])) || ($_POST['confirmPassword'] !== ($_POST['password']))) 
            {
                $errorConfirmPassword = 'password incorrect';
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
                
                $userId = $_POST['user_id'];
                
                $editModel = new AdminModel();
                
                $user = $editModel -> userById($userId);
                
                $this -> render('updateAdmin', [
                    'user' => $user,
                    'errors'=> $errors
                ]);
                
            }
            else
            {
                $userId = $_POST['user_id'];
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $model = new AdminModel;
                $data = [
                    htmlspecialchars($_POST['userName']),
                    htmlspecialchars($_POST['userStatus']),
                    htmlspecialchars($_POST['email']),
                    htmlspecialchars($password),
                    $userId
                
                //    htmlspecialchars($_POST['confirmPassword'])
                ];

                $model -> updateModelAdmin($data);

                redirect('/users');
            }
        }
        
        public function delete() :void
    {
        $id = $_GET['id'];
        $model = new AdminModel();
        $model -> deleteModelAdmin($id);
        redirect('/users');
    }
        
}

    
    