<?php

namespace Controllers;

use Models\AdminModel;

class LoginController extends Controller
{
    public function displayLogin()
    {
        $this -> render('login');
    }
   
    public function loginAccess()
    {
        // si $_SESSION "username" est défini et n'est pas vide et
        if(isset($_POST['username']) && !empty($_POST['username']) &&
        // $_SESSION "email" est defini et n'est pas vide et
        isset($_POST['email']) && !empty($_POST['email']) &&
        // $_SESSION "password" est défini et est n'est pas vide
        isset($_POST['password']) && !empty($_POST['password']))
        {
            $data = [
                htmlspecialchars($_POST['email'])
            ];
            // instanciation d'un model
            $model = new adminModel();
            // stockage de ce model dans une variable et appel de la fonction "checkUser"
            $check = $model -> checkUser($data);
            // si $check et $_POST"username" est egal $check"username" et
            if($check && $_POST['username'] == $check['user_name']  &&
            //verification du mot passe $_POST"password", $check"password"
                password_verify($_POST['password'], $check['user_password']))
            {
                //alors $_SESSION"ok" est égal à true
                $_SESSION['ok'] = true;
                    // contenu du $_SESSION "user"
                    $_SESSION['user'] = [
                        'id' => $check['user_id'],
                        'username' => $check['user_name'],
                        'userstatus' => $check['user_status'],
                        'email' => $check['user_email']
                    ];
                // puis redirect vers la vue "home"
                redirect('/home');
            }
            else
            {
                // sinon render de la vue "login               
                $this -> render('login');   
            }
        }
            else
            {
                // sinon render de la vue "login          
                $this -> render('login');   
            }            
        
    }

    public function logout():void
    {
        // destruction des variables de la session
        $_SESSION = [];
        // destruction de la session
        session_destroy();
        // redirect vers la page home
        redirect('/home');
    }
        
}
        
        
    