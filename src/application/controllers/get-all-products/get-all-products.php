<?php
require(__DIR__ . "./../../models/product");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
header('Content-Type: multipart/form-data; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getProducts();
        break;

    default:
        print('{"result": "unsupported request"}');
}

function getProducts()
{
    $accessBdd =  new ProductModel();
    $accessBdd->getAllProducts();
}