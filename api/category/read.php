<?php

use api\config\Database;
use api\objects\Category;


/* 
 read.php - file that will output JSON data based from "categories" database records.
 */

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/category.php';

//headers

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$database = new Database();

$db = $database ->getConnection();

$category = new Category($db);

$stmt = $category -> readAll();

$num = $stmt -> rowCount();

if($num>0){
    
    $categorries_arr = array();
    $categories_arr['records'] = array();
    
    while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
        
        extract($row);
        
        $record_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description)
        );
        
        array_push($categories_arr['records'],$record_item);
        
    }
    
    echo json_encode($categories_arr);
    
}else{
    echo json_encode(
        array("message" => "Categories not found")    
        );
}


