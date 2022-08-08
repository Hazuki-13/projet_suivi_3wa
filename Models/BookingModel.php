<?php

namespace Models;

use Admin\Database;

class BookingModel extends Database
{
    // protected Database $db;

        public function newBooking($data): void
        {
            // echo'<pre>';
            // var_dump($data);
            // echo '</pre>';
            $this->createOne('customers', 'cust_lastname, cust_firstname, cust_birthdate, cust_email', '?, ?, ?, ?', $data);
        }
                
        public function newBookingSuite($dataSuite): void
        {
            // echo'<pre>';
            // var_dump($dataSuite);
            // echo '</pre>';
            $this->createOne('booking', 'cust_id, cat_id, check_in, check_out', '?, ?, ?, ?', $dataSuite);
                
            
        }
            
        public function getLastCustomerId(): int
        {
            // on fait comme un select
            // sauf que je souhaite selectionner le dernier element
            // inserer dans la table customers
            $query = $this -> getPdo() -> lastInsertId();
            return $query;
            // var_dump($query);
        }

        public function findCustomer(string $id): array
        {
            $data = $this -> getOneById('customers','cust_id',
              $id  
            );
            return $data;
        }

        public function findBooking(string $id): array
        {
            $dataSuite = $this -> getOneById('booking','id_booking', 
                $id  
              );
              return $dataSuite;
        }

        public function updateModelCustomers(array $data): void
        {

            $this -> updateTable(' customers ', 'cust_lastname=?, cust_firstname=?, cust_birthdate=?, cust_email=?', 'cust_id', $data);
        
        }
        
        public function updateModelBooking(array $dataSuite): void
        {
            
            $this -> updateTable(' booking ', ' cat_id=?, check_in=?, check_out=?', 'id_booking', $dataSuite);
        }

        public function deleteModel(string $value): void
        {
    
            $this -> delete(' customers ', ' cust_id', $value);
        }

        // public function deleteBooking(): void
        // {

        // }

}