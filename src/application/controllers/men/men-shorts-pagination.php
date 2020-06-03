<?php
require(__DIR__ . "./../../models/men-women-kids-pagination.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


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
    $categoryName = 'men';
    $subcategoryName = 'shorts';
    $startPage = $_GET['start_page'];
    $numPerPage = $_GET['num_of_products'];
    $page = (int) $startPage;
    $numPage = (int) $numPerPage;

    $accessBdd =  new PaginateMenWomenKidsModel();
    $accessBdd->PaginateMenSubcategoryProducts($page, $numPage, $categoryName, $subcategoryName);
}

?>