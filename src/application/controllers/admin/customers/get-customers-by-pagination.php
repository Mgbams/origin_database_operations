<?php
require(__DIR__ . "./../../../models/customers.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getCustomers();
        break;

    default:
        print('{"result": "unsupported request"}');
}


function getCustomers()
{
    $startPage = $_GET['start_page'];
    $numPerPage = $_GET['num_of_customers'];
    $page = (int) $startPage;
    $numPage = (int) $numPerPage;

    $accessBdd =  new CustomersModel();
    $accessBdd->PaginateCustomers($page, $numPage);
}


?>