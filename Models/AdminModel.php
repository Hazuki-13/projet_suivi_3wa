<?php

namespace Models;

use Admin\Database;

class AdminModel extends Database
{
    public function readBookings(): array
    {
        // méthode permettant de recupérer plusieurs info des reservation via une requête stocker dans une variable $booking
        $bookings = 'SELECT booking.id_booking, booking.cust_id, customers.cust_lastname, customers.cust_firstname, customers.cust_birthdate, customers.cust_email, category.cat_title, booking.check_in, booking.check_out, booking.created_at
                     FROM booking
                     INNER JOIN customers ON customers.cust_id = booking.cust_id
                     INNER JOIN category ON category.cat_id = booking.cat_id
                     ORDER BY check_in ASC';
        return $this -> findAll($bookings);
    }
                     
    public function users(): array
    {
        // méthode permettant de recupérer plusieurs info des utilisateurs via une requête stocker dans une variable $users
        $users = 'SELECT user_id, user_name, user_status, user_email, created_at
                  FROM users';
                  return $this -> findAll($users);
    }

    public function userById( string $id): array
    {
        // methode permettant de recupérer un utilisateur par son id via une requête stocker dans la variable $user
        $user = $this -> getOneById('users', 'user_id', $id);
        return $user;
    }

    public function checkUser($data)
    {
        // methode permettant de verifier un utilisateur par son email via une requête dans une variable $email
        $email = $this -> getOneByEmail('users', 'user_id, user_name, user_status, user_email, user_password', $data);
        return $email;
    }

        public function newAdmin($data): void
    {
        // methode permettant de creer un utilisateur "admin" dans la table "users"
        $this -> createOne('users', 'user_name, user_status,  user_email, user_password', '?, ?, ?, ?', $data);
    }

    public function updateModelAdmin(array $data): void
    {
        // methode permettant de modifier un utilisateur "admin"
        $this -> updateTable(' users ', 'user_name=?, user_status=?, user_email=?, user_password=?', 'user_id', $data);
    }
    

    public function deleteModelAdmin(string $value): void
    {
        // méthode permettant de supprimer un utlisateur
        $this -> delete(' users ', ' user_id', $value);
    }


}