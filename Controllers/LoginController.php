<?php

namespace Controllers;

use Models\AdminModel;

class LoginController extends Controller
{
    public function displayLogin()
    {
        // $template =  'login' ;
        // require 'MVC/Views/layout.phtml';

        // la methode render remplace le code précedent
        $this -> render('login');
        
    }
    
    public function loginAccess()
    {
        if(isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password']))
        {
            $data = [
                htmlspecialchars($_POST['email'])
            ];

            $model = new adminModel();
            $check = $model -> checkUser($data);
            if($check && $_POST['username'] == $check['user_name']  &&
                password_verify($_POST['password'], $check['user_password']))
            {
                // echo('condition ok');
                // die();
                $_SESSION['ok'] = true;
                    $_SESSION['user'] = [
                        'id' => $check['user_id'],
                        'username' => $check['user_name'],
                        'email' => $check['user_email']
                    ];
                redirect('/home');
            }
            else
            {
                echo('condition pas ok');
                die();               
                $this -> render('login');   
            }
        }
            else
            {
                // echo('condition pas ok');
                // die();               
                $this -> render('login');   
            }            
        
    }

    public function logout():void
    {
        $_SESSION = [];
        session_destroy();
        redirect('/home');
    }
        
}
        
        
    