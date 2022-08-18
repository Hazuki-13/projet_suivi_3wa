<?php

namespace Admin;

use PDO;

class Database 
{
    // protected PDO $pdo;

    // public function __construct(array $config)
    // {   
    //     extract($config);
        
    //     $this -> pdo = new PDO("mysql: host=$host;dbName=$dbname; charset=UTF8", $user, $password, [
    //         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

    //     ]);
    // }

    public function __construct()
    {
        $this -> pdo = new PDO('mysql:host=db.3wa.io;dbname=alexandreangosto_projet_suivi;charset=UTF8', 'alexandreangosto', 'b2a7ffe6f7a5907ea8fc2cc231aab338',[
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        
                ]);;

    }

    public function getPdo():PDO
    {
        return $this -> pdo;
    }

    public function findAll(string $table, $params=[]): array
    {
        $query = $this -> getPdo() -> prepare($table);
        $query -> execute($params);
        $data = $query -> fetchAll();
        return $data;
        
    }

    public function find(string $table, $condition, $value, $params=[]): array
    {
        $query = $this -> getPdo() -> prepare('SELECT * 
                                               FROM $table
                                               WHERE $condition = ?');
        
        $query -> execute([$condition]);
        $data = $query -> fetch();
        return $data;
        
    }

    public function getOneById(string $table, string $pre ,$id)
    {

        $query = $this->getPdo()->prepare("SELECT * FROM " . $table . " WHERE " . $pre . " = ?");
        $query->execute([$id]);
        $data = $query->fetch();
        $query -> closeCursor(); // On indique au serveur que notre requete est terminée
        return $data;
    }

    protected function getOneByEmail($table, $column, $email)
    {
        $query = $this->getPdo()->prepare("SELECT " . $column . " FROM " . $table . " WHERE user_email = ?");
        $query->execute($email);
        $data = $query->fetch();
        $query->closeCursor(); // On indique au serveur que notre requete est terminée
        return $data;
    }

    protected function createOne(string $table, string $columns, string $values, $data )
    {
        $query = $this->getPdo()->prepare('INSERT INTO ' . $table . '(' . $columns . ') values (' . $values . ')');
        // var_dump($data);
        $query -> execute($data);
        $query -> closeCursor();
    }

    protected function updateTable( string $table, string $columns, string $condition, $data )
    {
        $query = $this->getPdo()->prepare('UPDATE ' . $table . ' 
                                            SET ' . $columns . ' WHERE ' . $condition . '= ?');
        // var_dump($data);
        $query -> execute($data);
        $query -> closeCursor();
    }
    
    public function delete(string $table, string $condition, string $value)
    {
        $query = $this->getPdo()->prepare('DELETE FROM' . $table . 'WHERE' . $condition . ' = ?');
        // echo'<pre>';
        // var_dump($query);
        // echo '</pre>';
        // die();
        $query->execute([$value]);
        $query->closeCursor();
    }
    
}