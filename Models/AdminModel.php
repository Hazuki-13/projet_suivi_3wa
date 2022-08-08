<?php

namespace Models;

use Admin\Database;

class AdminModel extends Database
{
    public function readBooking(): array
    {
        $bookings = 'SELECT booking.id_booking, booking.cust_id, customers.cust_lastname, customers.cust_firstname, customers.cust_email, category.cat_title, booking.check_in, booking.check_out, booking.created_at
                     
                     FROM booking
                     INNER JOIN customers ON customers.cust_id = booking.cust_id
                     INNER JOIN category ON category.cat_id = booking.cat_id
                     ORDER BY created_at DESC';
        return $this -> findAll($bookings);
        // echo'<pre>';
        // var_dump($bookings);
        // echo '</pre>';
        // die();
    }
    
    /*
    'SELECT b.id_booking, b.cust_id, c.cust_lastname, c.cust_firstname, c.cat_title, b.check_in, b.check_out 
    FROM booking
    INNER JOIN customers c ON c.cust_id = b.id_booking
    INNER JOIN category c ON c.cat_id = b.cat_id
    ORDER BY created_at DESC 
    
    DATE_FORMAT(booking.check_in, "%d/%m/%Y")
    DATE_FORMAT(booking.check_out, "%d/%m/%Y")
    DATE_FORMAT(booking.created_at "%d/%m/%Y")
    
    DATE_FORMAT(booking.check_in, "d/m/Y")
    
    */

    // public function updateModelCustomers(array $data, string $id): void
    // {

    //     $this -> update(' customers ', ' cust_lastname, cust_firstname, cust_birthdate, cust_email',  $data);

    //     echo'<pre>';
    //     var_dump($data);
    //     echo '</pre>';
    //     die();
    // }
    
    // public function updateModelBooking(array $dataSuite, string $id): void
    // {
        
    //     $this -> update(' booking ', ' cat_id, check_in, check_out', $dataSuite);

    //     echo'<pre>';
    //     var_dump($dataSuite);
    //     echo '</pre>';
    //     die();
    // }
    
    
        

    // public function deleteModel(): void
    // {
    //     $this -> getPdo -> delete('DELETE FROM booking WHERE id = ?');
    // }

}