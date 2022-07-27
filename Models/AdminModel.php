<?php

namespace Models;

use Admin\Database;

class AdminModel extends Database
{
    public function readBooking(): array
    {
        $bookings = 'SELECT booking.id_booking, booking.cust_id, customers.cust_lastname, customers.cust_firstname, category.cat_title, booking.check_in, booking.check_out 
                     FROM booking
                     INNER JOIN customers ON customers.cust_id = booking.id_booking
                     INNER JOIN category ON category.cat_id = booking.cat_id
                     ORDER BY created_at DESC';
        return $this -> findAll($bookings);
    }
}

/*
'SELECT b.id_booking, b.cust_id, c.cust_lastname, c.cust_firstname, c.cat_title, b.check_in, b.check_out 
 FROM booking
 INNER JOIN customers c ON c.cust_id = b.id_booking
 INNER JOIN category c ON c.cat_id = b.cat_id
 ORDER BY created_at DESC 



*/