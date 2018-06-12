<?php

namespace api\objects;

/* 
 product.php - contains properties and methods for "product" database queries.
 */

class Product{
    
    //database connection and table name
    private $conn;
    private $table_name = 'products';
    
    //object properties
    
    private $id;
    private $name;
    private $description;
    private $price;
    private $category_id;
    private $category_name;
    private $created;
    
    //constructor with db connection
    
    public function __construct($db) {
        $this -> conn = $db;
    }
    
    public function read(){
        
        //select all query
        
        $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created "
                . "FROM "
                . "{$this->table_name} p"
                . " LEFT JOIN"
                        . " categories c"
                        . " ON p.category_id = c.id"
                        . " ORDER BY"
                        . " p.created DESC";
      
        //prepare query statement
                
        $stmt = $this -> conn -> prepare($query);
        
        $stmt -> execute();
                
        return $stmt;
        
    }
    
}