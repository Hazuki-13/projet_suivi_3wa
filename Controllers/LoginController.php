<?php

namespace Controllers;

class LoginController extends Controller
{
    public function displayLogin()
    {
        // $template =  'login' ;
        // require 'MVC/Views/layout.phtml';

        // la methode render remplace le code précedent
        $this -> render('login');
        
    }
    public function displayAddAdmin()
    {
        // $template =  'login' ;
        // require 'MVC/Views/layout.phtml';

        // la methode render remplace le code précedent
        $this -> render('addAdmin');
        
    }

    public function loginAccess()
    {
        $error = false;
        $errorUserName = '';
        $errorEmail = '';
        $errorPassword = '';

        if(!isset($_POST['username']) || (isset($_POST['username']) && empty($_POST['username'])))
        {
            $errorUserName = '';
            $error = true;
        }

        if(!isset($_POST['email']) || (isset($_POST['email']) && empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))
        {
            $errorEmail = '';
            $error = true;
        }

        if(!isset($_POST['password']) || (isset($_POST['password']) && empty($POST['password'])))
        {
            $errorPassword = '' ;
            $error = true;
        }

        $_SESSION['message']= [
            'username' => $errorUserName,
            'email' => $errorEmail,
            'password' => $errorPassword,
        ];

        // echo('<pre>');
        // print_r($_SESSION['message']);
        // echo ('</pre>');
        // die();

        if($error)
        {
            $_SESSION['data'] = [
                'username' => htmlspecialchars($_POST['username']),
                'email' => htmlspecialchars($_POST['email']),
                'password' => htmlspecialchars($_POST['password']),
            ];

            // echo('<pre>');
            // print_r($_SESSION['data']);
            // echo ('</pre>');
            // die();

            $this -> render('login');
        }



    }

    // public function accessGranted()
    // {
        
    // }
}