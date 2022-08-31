<?php

namespace Models;

use Admin\Database;

class BookingModel extends Database
{
        public function newBooking($data): void
        {
            // Méthode permettant de creer une réservation (partie 1)
            $this->createOne('customers', 'cust_lastname, cust_firstname, cust_birthdate, cust_email', '?, ?, ?, ?', $data);
        }
                
        public function newBookingSuite($dataSuite): void
        {
            // Méthode permettant de creer une reservation (partie 2)
            $this->createOne('booking', 'cust_id, cat_id, check_in, check_out', '?, ?, ?, ?', $dataSuite);
        }
                
        public function getLastCustomerId(): int
        {
            // methode permettant de selectionner le dernier élément insérer dans la table customers
            $query = $this -> getPdo() -> lastInsertId();
            return $query;
        }
            
        public function findCustomer(string $id): array
        {
            // methode permettant de trouver un customer par son id
            $data = $this -> getOneById('customers','cust_id', $id);
            return $data;
        }
            
        public function findBooking(string $id): array
        {
            // methode permettant de trouver une reservation par son id
            $dataSuite = $this -> getOneById('booking','id_booking', $id);
              return $dataSuite;
        }

        public function updateModelCustomers(array $data): void
        {
            // methode permettant de modifier un customer
            $this -> updateTable(' customers ', 'cust_lastname=?, cust_firstname=?, cust_birthdate=?, cust_email=?', 'cust_id', $data);
        
        }

        public function updateModelBooking(array $dataSuite): void
        {
            // methode permettant de modifier une réservation
            $this -> updateTable(' booking ', ' cat_id=?, check_in=?, check_out=?', 'id_booking', $dataSuite);
        }

        public function deleteModel(string $value): void
        {
            // methode permettant de supprimer un customer (qui supprimera la reservation en cascade)
            $this -> delete(' customers ', ' cust_id', $value);
        }
        


}