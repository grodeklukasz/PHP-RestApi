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


