<?php
require(__DIR__ . "./../../models/men-women-kids.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getData();
        break;

    default:
        print('{"result": "unsupported request"}');
}


function getData()
{
    $categoryName = 'women';
    $subcategoryName = 'accessoires';

    $accessBdd =  new MenWomenKidsModel();
    $accessBdd->getAccessoires($categoryName, $subcategoryName);
}

?>
