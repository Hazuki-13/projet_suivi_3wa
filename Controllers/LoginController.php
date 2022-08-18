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
        // $password = '12321';
        // $algo = 'PASSWORD_BCRYPT';
        // $pHash = password_hash( $password, PASSWORD_BCRYPT);

        // var_dump($pHash);
        // die();

        if(isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password']))
        {
            $data = [
                htmlspecialchars($_POST['email']),
            ];

            $model = new adminModel();
            $check = $model -> checkUser($data);
            if($check == false){
                $this -> render('login');
            }
            else{
                if($_POST['username'] == $check['user_name'] &&
                $_POST['email'] == $check['user_email'] &&
                password_verify($_POST['password'], $check['user_password']))
                {
                    $_SESSION['user'] = true;
                    echo('connected');
                    
                    echo'<pre>';
                    var_dump($_SESSION['user']);
                    echo '</pre>';
                    // // die();

                    // $model = new AdminModel;
                    // $bookingList = $model -> readBooking();
                    // $this -> render('super-admin-control',[
                    //     'booking' => $bookingList
                    // ]);

                    redirect('/super-admin-control');
                }
                else{
                    $this -> render('login');
                }   
            }
            // echo'<pre>';
            // var_dump($data);
            // echo '</pre>';
            // // die();
            
            
        }
        
    }

    public function logout():void
    {
        $_SESSION = [];
        session_destroy();
        redirect('/home');
    }
        
    public function displayAddAdmin()
    {
        // $template =  'login' ;
        // require 'MVC/Views/layout.phtml';
        // la methode render remplace le code précedent

        $this -> render('addAdmin');
        
    }
    
    // public function createAdmin()
    // {
        
    // }
}
        
        
    