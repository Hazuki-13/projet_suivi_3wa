<?php

namespace Models;

use Admin\Database;

class RoomModel extends Database
{
    

    // public function getRooms()
    // {
    //     return $this -> findAll('room');
    // }

    // public function getDb()
    // {
    //     return $this -> db;
    // }

    public function getRooms():array
    {
      $room = 'SELECT * 
      FROM category';
      return $this -> findAll($room);
    }

    
    // public function getRooms():array
    // {
    //   $query = $this -> getPdo() -> prepare(  'SELECT * 
    //                                             FROM rooms');
      
    //   $room = $query -> fetch();
    //   var_dump($room);
    //   return $room;
    // }

    // public function getRooms():array
    // {
    //     $table = 'SELECT *, category.cat_title 
    //               FROM rooms
    //               INNER JOIN category 
    //                 ON category.cat_id = rooms.cat_id
    //               ORDER BY rooms.cat_id ASC';
    //     return $this -> findAll($table);
    // }
    
}

