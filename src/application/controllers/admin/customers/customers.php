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

    case 'DELETE': // read data
        deleteCustomer();
        break;

    default:
        print('{"result": "unsupported request"}');
}


function getCustomers()
{
    $accessBdd =  new CustomersModel();
    $accessBdd->getCustomers();
}

function deleteCustomer()
{
    $id = $_GET['id'];
    $customerId = (int)$id;

    $accessBdd =  new CustomersModel();
    $accessBdd->deleteCustomer($customerId);
}

?>