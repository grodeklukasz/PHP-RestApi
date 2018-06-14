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
    
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
    
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
    
    public function create(){
        $sql = "INSERT INTO "
                . $this->table_name .
                " SET "
                . "name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
        //prepare query
        $stmt = $this -> conn -> prepare($sql);
        
        //sanitize
        
        $this -> name = htmlspecialchars(strip_tags($this->name));
        $this -> price = htmlspecialchars(strip_tags($this->price));
        $this -> description = htmlspecialchars(strip_tags($this->description));
        $this -> category_id = htmlspecialchars(strip_tags($this->category_id));
        $this -> created = htmlspecialchars(strip_tags($this -> created));
        
        //bind values
        
        $stmt -> bindParam(":name",$this->name);
        $stmt -> bindParam(":price",$this->price);
        $stmt -> bindParam(":description",$this->description);
        $stmt -> bindParam(":category_id",$this->category_id);
        $stmt -> bindParam(":created",$this->created);
        
        if($stmt->execute()){
            return TRUE;
        }
        
        return FALSE;
        
        
    }
    
    
    //  used when filling up the update product form
    
    public function readOne(){
        
        $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created "
                . "FROM "
                . "{$this->table_name} p"
                . " LEFT JOIN"
                        . " categories c"
                        . " ON p.category_id = c.id"
                        . " WHERE"
                        . " p.id = ?";
        
               
                
        //prepare query
        //new comment for Master Branch
        $stmt = $this -> conn -> prepare($query);
        
        //bind properties
        $stmt -> bindParam(1, $this -> id);
        
      
        //execute query
        $stmt -> execute();
        
        //get retrieved row
        $row = $stmt -> fetch(\PDO::FETCH_ASSOC);
        
        //set values to object properties
        
        $this -> name = $row['name'];
        $this -> price = $row['price'];
        $this -> description = $row['description'];
        $this -> category_id = $row['category_id'];
        $this -> category_name = $row['category_name'];
        
       
    }
    
    //update the product
    public function update(){
        
        $query = "UPDATE "
                . $this -> table_name 
                . " SET"
                . " name= :name,"
                . " price= :price,"
                . " description= :description,"
                . " category_id= :category_id"
                . " WHERE"
                . " id= :id";
        
        //prepare query statement
        
        $stmt = $this -> conn -> prepare($query);
        
        //sanitize
        
        $this -> name = htmlspecialchars(strip_tags($this->name));
        $this -> description = htmlentities(strip_tags($this->description));
        $this -> price = htmlspecialchars(strip_tags($this->price));
        $this -> category_id = htmlspecialchars(strip_tags($this->category_id));
        $this -> id = htmlspecialchars(strip_tags($this->id));
        
        //bind new values
        
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":desription",$this->description);
        $stmt->bindParam(":price",$this->price);
        $stmt->bindParam(":category_id",$this->category_id);
        $stmt->bindParam(":id",$this->id);
        
        
        //execute 
        
        if($stmt -> execute()){
            return TRUE;
        }else{
            return FALSE;
        }
        
        
    }
    
    public function delete(){
        
        //delete query
        $query = "DELETE FROM " . $this -> table_name . " WHERE id=?";
        
        //prepare query
        $stmt = $this -> conn -> prepare($query);
        
        //sanitize
        
        $this -> id = htmlspecialchars(strip_tags($this -> id));
        
        $stmt -> bindParam(1,$this->id);
        
        if($stmt->execute()){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }
    
    public function search($keywords){
        
        $sql = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created"
                . " FROM "
                . $this -> table_name . " p"
                . " LEFT JOIN"
                . " categories c"
                . " ON p.category_id=c.id"
                . " WHERE"
                . " p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?"
                . " ORDER BY"
                . " p.created DESC";
        
        $stmt = $this -> conn -> prepare($sql);
        
        //sanitize
        
        $keywords = htmlentities(strip_tags($keywords));
        
        $keywords = "%{$keywords}%";
        
        $stmt -> bindParam(1,$keywords);
        $stmt -> bindParam(2,$keywords);
        $stmt -> bindParam(3,$keywords);
        
        $stmt->execute();
        
        return $stmt;
    }
    
    
    
}