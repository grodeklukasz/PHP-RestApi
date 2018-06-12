<?php

namespace api\config;

/* 
database.php - file used for connecting to the database.
 */

class Database{
    
    private $host = 'localhost';
    private $db_name = 'api_db';
    private $username = 'admin';
    private $password = 'admin';
    public $conn;
    
    //get connection to Database
    
    public function getConnection(){
        $this -> conn = null;
        try{
            $this -> conn = new \PDO("mysql:host=" . $this ->  host . ";dbname=" . $this -> db_name , $this -> username, $this -> password);
            $this -> conn -> exec("set names utf8");
        } catch (PDOException $ex) {
            print "Connection error:{$ex->getMessage()}";
        }
        return $this -> conn;
    }
    
    
}