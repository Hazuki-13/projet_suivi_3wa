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

    public function getPictures():array
    {
      //recupérarion des détails de la category des rooms
      //selection de toutes les colonnes sans utiliser l'*
      $pictures = 'SELECT picture_id, cat_id, picture_url
      FROM pictures_details';
      return $this -> findAll($pictures);
    }
    
    // public function getRooms():array
    // {
    //           //recupérarion des détails de la category des rooms
    //           //selection de toutes les colonnes sans utiliser l'*
    //           $room = 'SELECT category.cat_id, category.cat_title, category.cat_description, pictures_details.picture_url, cat_price
    //                   FROM category
    //                   INNER JOIN pictures_details ON pictures_details.cat_id = category.cat_id';
    //           return $this -> findAll($room);
    // }
}
        



// public function getRooms():array
    // {
    //     $table = 'SELECT *, category.cat_title 
    //               FROM rooms
    //               INNER JOIN category 
    //                 ON category.cat_id = rooms.cat_id
    //               ORDER BY rooms.cat_id ASC';
    // 
    //     return $this -> findAll($table);
    // }

