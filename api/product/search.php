<?php

use api\config\Database;
use api\objects\Product;

/* 
search.php - file that will accept keywords parameter to search "products" database.
 */

//required headers

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/product.php';

//include database and objects files

$database = new Database();

$db = $database ->getConnection();

//initialize object
$product = new Product($db);

//get keywords
$keywords = isset($_GET['s']) ? $_GET['s'] : "";

//query products
$stmt = $product ->search($keywords);
$num = $stmt->rowCount();

//check if more then 0 records found
if($num>0){
    
    //products array
    $products_arr = array();
    $products_arr['records'] = array();
    
    while($row = $stmt -> fetch(\PDO::FETCH_ASSOC)){
        
        extract($row);
        
        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );
        
        array_push($products_arr['records'], $product_item);
        
    }
    
    echo json_encode($products_arr);
    
}else{
    
    echo json_encode(
        
            array("message" => "No products found.")
            
    );
    
}
