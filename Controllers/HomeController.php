<?php

namespace Controllers;

class HomeController extends Controller
{
    public function displayHome()
    {
        // $template =  'home' ;
        // require 'MVC/Views/layout.phtml';
        
        // la methode render remplace le code précedent
        $this -> render('home');
    }

    public function displayRoom()
    {
    //     // $template =  'room' ;
    //     // require 'MVC/Views/layout.phtml';
            $model = new \Models\RoomModel();
            $rooms = $model -> getRooms();
            
    //     // la methode render remplace le code précedent
        $this -> render('room', [
                    'rooms' => $rooms
                 ]);
        
    }

    public function displayBuffet()
    {
        // $template =  'buffet' ;
        // require 'MVC/Views/layout.phtml';
        
        // la methode render remplace le code précedent
        $this -> render('buffet');
    }

}