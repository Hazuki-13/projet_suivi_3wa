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
}