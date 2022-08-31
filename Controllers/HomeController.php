<?php

namespace Controllers;

class HomeController extends Controller
{
    public function displayHome():void
    {
        /* $template =  'home' ;
        ** require 'MVC/Views/layout.phtml';
        ** la methode render remplace le code précedent
        */ 
        $this -> render('home');
    }
}
        
