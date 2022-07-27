<?php

namespace Controllers;

class RoomController extends Controller
{
    public function displayRooms(): void
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
}

    