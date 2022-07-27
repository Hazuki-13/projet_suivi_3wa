<?php

namespace Models;

use Admin\Database;

class RoomModel extends Database
{
    public function getRooms():array
    {
      //recupérarion des détails de la category des rooms
      //selection de toutes les colonnes sans utiliser l'*
      $room = 'SELECT cat_id, cat_title, cat_description, cat_price
      FROM category';
      return $this -> findAll($room);
    }
}

