<?php

namespace Controllers;

class RoomController extends Controller
{
    public function displayRooms(): void
    {
        $model = new \Models\RoomModel();
        $rooms = $model -> getRooms();
        $model = new \Models\RoomModel();
        $pictures = $model -> getPictures();
        
        

        // echo('<pre>');
        // print_r($rooms);
        // echo ('</pre>');
        // echo('<pre>');
        // print_r($pictures);
        // echo ('</pre>');
        // echo('<pre>');
        // print_r($);
        // echo ('</pre>');
        // die();

        //la methode render remplace le code précedent
        $this -> render('room', [
            'rooms' => $rooms,
            'pictures' => $pictures
        ]);
    }
}

    