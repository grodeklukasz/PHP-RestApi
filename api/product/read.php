<?php

use api\config\Database;
use api\objects\Product;

/* 
read.php - file that will output JSON data based from "products" database records.
 */


//required headers 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/product.php';

//new object Database

$database = new Database();

//get connection to Database

$db = $database->getConnection();

$product = new Product($db);


$stmt = $product -> read();

$num = $stmt -> rowCount();

//check if more then 0 record found

if($num>0){
    
    $products_arr = array();
    $products_arr['records'] = array();
    
    while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
        
        //extract row
        // this will make $row['name'] to
        //just $name only
        
        extract($row);
        
        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name   
        );
        
        array_push($products_arr['records'],$product_item);
        
    }
    
    echo json_encode($products_arr);
    
}else{
    echo json_encode(
            array("message" => "No products found.")
            );
}
?>