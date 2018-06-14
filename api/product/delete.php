<?php

use api\config\Database;

/* 
 delete.php - file that will accept a product ID to delete a database record.
 */

//headers

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object file

include_once __DIR__ . '/../config/Database.php';

include_once __DIR__ . '/../objects/Product.php';

//instance of Database

$database = new Database();

//get Connection
$db = $database ->getConnection();

$product = new Product($db);

$data = json_decode(file_get_contents('php:\\input'));

//set product id to be deleted

$product -> id = $data -> id;

if($product->delete()){
    echo "message: Product was deleted";
}else{
    echo "message: Unable to delete object.";
}
