<?php

use api\config\Database;

use api\objects\product;

/* 
create.php - file that will accept posted product data to be saved to database.
 */

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

//add Database config file
include_once __DIR__ . '/../config/Database.php';

//add object Product
include_once __DIR__. '/../objects/product.php';

$database = new Database();

$db = $database -> getConnection();

$product = new Product($db);

//get posted Data
$data = json_decode(file_get_contents('php://input'));

//set product property

$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data -> category_id;
$product->created = data('Y-m-d H:i:s');

//create the product
if($product->create()){
    echo "message: Product was created";
}else{
    echo "message: Unable to create create";
}


