<?php

namespace Models;

use Admin\Database;

class RoomModel extends Database
{
    public function getRooms():array
    {
      //recupérarion des détails de la category des rooms
      $room = 'SELECT cat_id, cat_title, cat_description, cat_price
      FROM category';
      return $this -> findAll($room);
    }

    public function getPictures():array
    {
      //recupérarion des détails de la category des rooms
      $pictures = 'SELECT picture_id, cat_id, picture_url, picture_alt
      FROM pictures_details';
      return $this -> findAll($pictures);
    }

    public function searchById(string $id): array
    {
        $search = $this -> getOneById('category', 'cat_id', $id);
        return $search;
    }
}
    
    
