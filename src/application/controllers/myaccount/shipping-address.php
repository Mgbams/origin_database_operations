<?php
require(__DIR__ . "./../../models/myaccount.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // read data
        getShippingAddress();
        break;
    case 'PUT': // read data
        updateShippingAddress();
        break;
    default:
        print('{"result": "unsupported request"}');
}

function updateShippingAddress()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  var_dump($_POST);
  $firstName        =  $_POST['firstName']; 
  $lastName         =  $_POST['lastName']; 
  $country          =  $_POST['country'];
  $shippingAddr     =  $_POST['address']; 
  $postalCode       =  $_POST['postalCode'];
  $city             =  $_POST['city']; 
  $phoneNo          =  $_POST['phone'];
  $id               =  $_GET['id'];
  $customerId       =  (int)$id;
  
  $updateCustomerPassword = new MyAccountModel();
    try {
        $updateCustomerPassword->updateShippingAddress($firstName, $lastName, $country, $shippingAddr, $postalCode, $city, $phoneNo, $customerId);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
} 

function getShippingAddress()
{
    $id = $_GET['id'];
    $accessBdd =  new MyAccountModel();
    $accessBdd->getShippingAddressById($id);
}

?>