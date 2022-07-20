<?php

namespace Models;

use Admin\Database;

class BookingModel extends Database
{
    // protected Database $db;

        public function newBooking($data)
        {
            // echo'<pre>';
            // var_dump($data);
            // echo '</pre>';
            $this->createOne('customers', 'cust_lastname, cust_firstname, cust_birthdate, cust_email', '?, ?, ?, ?', $data);
        }
                
        public function newBookingSuite($dataSuite)
        {
            // echo'<pre>';
            // var_dump($dataSuite);
            // echo '</pre>';
            $this->createOneSuite('booking', 'cust_id, cat_id, check_in, check_out', '?, ?, ?, ?', $dataSuite);
                
            
        }
            
        public function getLastCustomerId()
        {
            // on fait comme un select
            // sauf que je souhaite selectionner le dernier element
            // inserer dans la table customers
            $query = $this -> getPdo() -> lastInsertId();
            return $query;
            // var_dump($query);
        }


        
            // 'SELECT *, category.cat_title 
            //       FROM rooms
            //       INNER JOIN category 
            //         ON category.cat_id = rooms.cat_id
            //       ORDER BY rooms.cat_id ASC';
            // return $this -> find($room);
            // var_dump($query);

            // $this->getPdo->createOne(  'customers',
            //                 'cust_lastname, cust_firstname, cust_birthdate, cust_email' ,
            //                 '?,?,?,?',
            //                 $data);


        // $this -> db -> execute(
        //     'INSERT INTO posts ( category_id, title, content, user_id, created_at) VALUES (
        //     ?, ?, ?, ?, NOW())' , [
                
        //         $formData ['category_id'],
        //         $formData ['title'],
        //         $formData ['content'],
        //         $userId
        //         ]
        //         );


        // public function addNewArticle($data) {
        //     $this->addOne(  'articles',
        //                     'art_title, art_undertitle, art_description, art_price, art_img, art_date_sortie, art_category, art_date_create_article',
        //                     '?,?,?,?,?,?,?,?',
        //                     $data);
        


            // $query = $this->db->prepare //('INSERT INTO ' . $table . '(' . $columns . ') values (' . $values . ')');
            //                            ('INSERT INTO booking ( cust_id, room_id, check_in, ckeck_out, created_at) , customers ( cust_lastname, cust_firstname, cust_birthdate) 
            //                              VALUES ( ?, ?, ?, ?, NOW(), ?, ?, ?)' , [
            //                              $form ['cust_id'],
            //                              $form ['room_id'],
            //                              $form ['check_in'],
            //                              $form ['check_out'],
            //                              $form ['cust_lastname'],
            //                              $form ['cust_firstname'],
            //                              $form ['cust_birthdate']                                    
            //                              ]
            //                              );

}