<?php

namespace api\objects;

/* 
 category.php - contains properties and methods for "category" database queries.
 */

class Category{
    
    private $conn;
    private $table_name = 'categories';
    
    public $id;
    public $name;
    public $description;
    public $created;
    public $modified;
    
    public function __construct($db) {
        $this -> conn = $db;
    }


    public function readAll(){
        
        $sql = "SELECT id, name, description FROM "
                . $this -> table_name 
                . " ORDER BY name";
               
        $stmt = $this -> conn -> prepare($sql);
        
        $stmt -> execute();
        
        return $stmt;
        
    }
    
}