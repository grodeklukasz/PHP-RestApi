<?php

use api\config\Database;
use api\objects\product;

/* 
read_one.php - file that will accept product ID to read a record from the database.
 */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

//add Database config file
include_once __DIR__ . '/../config/database.php';

//add object Product
include_once __DIR__. '/../objects/product.php';

//prepare product 

$database = new Database();
$db = $database ->getConnection();

$product = new Product($db);

//set ID property of product to be edited
$product -> id = isset($_GET['id']) ? $_GET['id'] : die();

//read the details of product to be edited

$product -> readOne();

//create array
$product_arr = array(
    "id" => $product -> id,
    "name" => $product -> name,
    "description" => $product -> description,
    "price" => $product -> price,
    "category_id" => $product ->category_id,
    "category_name" => $product -> category_name
);



//make it json format

print_r(json_encode($product_arr));
