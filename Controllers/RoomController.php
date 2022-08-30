<?php

namespace Controllers;

class RoomController extends Controller
{
    public function displayRooms(): void
    {
        // instanciation d'un nouveau model
        $model = new \Models\RoomModel();
        // stockage de ce model dans une variable puis appel de la fonction "getRooms"
        $rooms = $model -> getRooms();
        // instanciation d'un nouveau model
        $model = new \Models\RoomModel();
        // stockage de ce model dans une variable puis appel de la fonction "getPictures"
        $pictures = $model -> getPictures();
        // puis render de la vue avec ses 2 variables necessaire à l'affichage
        $this -> render('room', [
            'rooms' => $rooms,
            'pictures' => $pictures
        ]);
    }
}

    