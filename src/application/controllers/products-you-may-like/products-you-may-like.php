<?php
require(__DIR__ . "./../../models/products-you-may-like.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getCategoryById();
        break;

    default:
        print('{"result": "unsupported request"}');
}

function getCategoryById()
{
    $categoryName = $_GET['category_name'];
    $subcategoryName = $_GET['subcategory_name'];
    $accessBdd = new ProductsYouMayLikeModel();
    try {
        $accessBdd->getSuggestedProducts($categoryName, $subcategoryName);
    } catch(Exception $e) {
        echo "big error";
    }
   
}

?>