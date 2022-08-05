<?php

namespace Admin;

use PDO;

class Database 
{
    protected PDO $pdo;

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

    // public function findAll($table)
    // {
    //     $query = $this -> getPdo() -> prepare ("SELECT * FROM $table") ;
    //     $query -> execute();
    //     return $query -> fetchAll();
        
    // }
    public function findAll(string $table, $params=[]): array
    {
        $query = $this -> getPdo() -> prepare($table);
        $query -> execute($params);
        $data = $query -> fetchAll();
        return $data;
        
    }

    public function getOneById(string $table, string $pre ,$id)
    {
        // if (!empty($table) && !empty($pre) && !empty($idCol) &&!empty($id)){

            $query = $this->getPdo()->prepare("SELECT * FROM " . $table . " WHERE " . $pre . " = ?");
            $query->execute([$id]);
            $data = $query->fetch();
            $query -> closeCursor(); // On indique au serveur que notre requete est terminée
            return $data;
        // }
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

    // public function createOne(string $table, $condition, $value, $params=[]): array
    // {
    //     $query = $this -> getPdo() -> prepare('INSERT INTO * 
    //                                            FROM $table
    //                                            WHERE $condition = ?');
        
    //     $query -> execute([$condition]);
    //     $data = $query -> fetch();
    //     return $data;
        
    // }
    
    
    protected function createOne(string $table, string $columns, string $values, $data )
    {
        $query = $this->getPdo()->prepare('INSERT INTO ' . $table . '(' . $columns . ') values (' . $values . ')');
        // var_dump($data);
        $query -> execute($data);
        $query -> closeCursor();
    }

    // protected function addOne($query, $query2, $data )
    // {
    //     $query = $this->getPdo()->prepare($query, $query2);
    //     $query->execute($data);
    //     $query->closeCursor();
    // }

    protected function createOneSuite(string $table, string $columns, string $values, $dataSuite )
    {
        $query = $this->getPdo()->prepare('INSERT INTO ' . $table . '(' . $columns . ') values (' . $values . ')');
        // var_dump($dataSuite);
        $query -> execute($dataSuite);
        $query -> closeCursor();
    } 
    
    
    
    // public function booking(string $table, $columns, $data)
// {
    //     $query = $this -> getPdo() -> prepare('INSERT INTO customers, rooms, buffet, booking 
    //                                            FROM $table
    //                                            WHERE $columns = ?');
    //     $query->execute($data);
    // 
// }
//   
//  public fuction booking (string $table, $columns, $data)
// {                                     
    //     $query = $this -> getPdo() -> prepare('
    //                  INSERT INTO customers FROM $table WHERE $columns = ?');
    //                  SELECT LAST_INSERT_ID() FROM customers;
    //                  INSERT INTO booking FROM $table WHERE $columns = ?');
    // 
    // 
    //     $query->execute($data);
    // }

    
    // protected function update(string $table, string $condition, string $value)
    // {
    //     $query = $this->getPdo()->prepare('UPDATE ' . $table . ' SET(' . $condition . ') values (' . $value . ')');
    //     // var_dump($data);
    //     $query -> execute([$value]);
    //     $query -> closeCursor();
    // }
    
    // protected function update(string $table, string $column, string $condition, string $value)
    // {
    //     $query = $this->getPdo()->prepare('UPDATE ' . $table . ' SET ' . $column . ' "WHERE id = ?"');
    //     // var_dump($data);
    //     $query -> execute([$value]);
    //     $query -> closeCursor();
    // }

    
    public function update(string $table, $condition, $value, $params=[]): array
    {
        $query = $this -> getPdo() -> prepare('UPDATE *  
                                               FROM $table
                                               WHERE $condition = ?');
        
        $query -> execute([$value]);
    //     $data = $query -> fetch();
        return $value;
        
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