<?php
require(__DIR__ . "./../../models/sub-category.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getAllSubCategories();
        break;

    default:
        print('{"result": "unsupported request"}');
}


function getAllSubCategories()
{
    $accessBdd = new SubCategoryModel();
    try {
        $accessBdd->getAllSubCategories();
    } catch(Exception $e) {
        echo "big error";
    }
}
?>