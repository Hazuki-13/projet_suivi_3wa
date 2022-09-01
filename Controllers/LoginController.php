<?php

namespace Controllers;

use Models\AdminModel;

class LoginController extends Controller
{
    // Display de la page login avec la méthode render
    public function displayLogin()
    {
        $this -> render('478845ZrqQifzZ9ymRHF_login');
    }
   
    public function loginAccess()
    {
        // vérification des données pour la connexion
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
                $_SESSION['ok'] = true;
                $_SESSION['user'] = [
                    'id' => $check['user_id'],
                    'username' => $check['user_name'],
                    'userstatus' => $check['user_status'],
                    'email' => $check['user_email']
                ];
                    
                redirect('/home');
            }
            else
            {               
                $this -> render('478845ZrqQifzZ9ymRHF_login');   
            }
        }
            else
            {          
                $this -> render('478845ZrqQifzZ9ymRHF_login');   
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
        
        
    