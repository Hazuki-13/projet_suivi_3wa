<?php

namespace Admin;

use PDO;

class Database 
{
    protected PDO $pdo;

    public function __construct()
    {
        $this -> pdo = new PDO('mysql:host=db.3wa.io;dbname=alexandreangosto_projet_suivi;charset=UTF8', 'alexandreangosto', 'b2a7ffe6f7a5907ea8fc2cc231aab338',[
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        
                ]);
    }
    // Getter de la connexion PDO
    public function getPdo(): PDO
    {
        return $this -> pdo;
    }

    // méthode générique pour récupérer tous les eléménts d'une table
    public function findAll(string $table, $params=[]): array
    {
        $query = $this -> getPdo() -> prepare($table);
        $query -> execute($params);
        $data = $query -> fetchAll();
        return $data;
        
    }

    // méthode générique permettant de récupérer une donnée bien précise
    public function find(string $table, $condition, $value, $params=[]): array
    {
        $query = $this -> getPdo() -> prepare('SELECT * 
                                               FROM $table
                                               WHERE $condition = ?');
        
        $query -> execute([$condition]);
        $data = $query -> fetch();
        return $data;
        
    }
    // méthode permettant de récupérer une donnée par son id
    protected function getOneById(string $table, string $pre ,$id)
    {

        $query = $this -> getPdo() -> prepare("SELECT * FROM " . $table . " WHERE " . $pre . " = ?");
        $query -> execute([$id]);
        $data = $query -> fetch();
        $query -> closeCursor(); // On indique au serveur que notre requete est terminée
        return $data;
    }

    // méthode permettant de récupérer une donnée par son email
    protected function getOneByEmail($table, $column, $email)
    {
        $query = $this -> getPdo() -> prepare("SELECT " . $column . " FROM " . $table . " WHERE user_email = ?");
        $query -> execute($email);
        $data = $query->fetch();
        $query -> closeCursor();
        return $data;
    }

    // méthode permettant de récupérer une donnée par son nom
    protected function getOneByName($table, $column, $name)
    {
        $query = $this -> getPdo( )-> prepare("SELECT " . $column . " FROM " . $table . " WHERE user_name = ?");
        $query -> execute($name);
        $data = $query -> fetch();
        $query -> closeCursor();
        return $data;
    }

    // méthode générique permettant de créér/insérer une donnée dans une table
    protected function createOne(string $table, string $columns, string $values, $data )
    {
        $query = $this -> getPdo() -> prepare('INSERT INTO ' . $table . '(' . $columns . ') values (' . $values . ')');
        // var_dump($data);
        $query -> execute($data);
        $query -> closeCursor();
    }

    // méthode générique permettant de mofifier une ou plusieurs donnée(s) dans une table
    protected function updateTable( string $table, string $columns, string $condition, $data )
    {
        $query = $this -> getPdo()->prepare('UPDATE ' . $table . ' 
                                            SET ' . $columns . ' WHERE ' . $condition . '= ?');
        $query -> execute($data);
        $query -> closeCursor();
    }
    
    // méthode générique permettant de supprimer une ligne dans une table
    public function delete(string $table, string $condition, string $value)
    {
        $query = $this -> getPdo() -> prepare('DELETE FROM' . $table . 'WHERE' . $condition . ' = ?');
        $query -> execute([$value]);
        $query -> closeCursor();
    }
    
}

