<?php

namespace Controllers;

class RoomController extends Controller
{
    public function displayRooms(): void
    {
        // récupération de toutes les "rooms" pour l'affichage dans la vue "rooms
        $model = new \Models\RoomModel();
        $rooms = $model -> getRooms();
        $model = new \Models\RoomModel();
        $pictures = $model -> getPictures();
        $this -> render('room', [
            'rooms' => $rooms,
            'pictures' => $pictures
        ]);
    }
}

    