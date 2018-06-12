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
    
}