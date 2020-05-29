<?php
require(__DIR__ . "./../../models/myaccount.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'PUT': // read data
        updatePaymentsInfo();
        break;
    case 'POST': // read data
        postPaymentsInfo();
        break;
    default:
        print('{"result": "unsupported request"}');
}

function updatePaymentsInfo()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  var_dump($_POST);
  $nickName        =     $_POST['nickName']; 
  $firstName       =     $_POST['firstName']; 
  $lastName        =     $_POST['lastName']; 
  $shippingId      =     $_POST['shippingAddress']; 
  $paymentAddress  =     $_POST['address']; 
  $postalCode      =     $_POST['postalCode']; 
  $country         =     $_POST['country']; 
  $city            =     $_POST['city']; 
  $cardNo          =     $_POST['cardNo']; 
  $phoneNo         =     $_POST['phone']; 
  $month           =     $_POST['month']; 
  $year            =     $_POST['year']; 
  $cvv             =     $_POST['cvv'];
  $id              =     $_GET['id'];
  $customerId      =     (int)$id;
  
  $updateCustomerPassword = new MyAccountModel();
    try {
        $updateCustomerPassword->updatePaymentsInfos($nickName, $firstName, $lastName, $shippingId, $paymentAddress, $postalCode, $country, $city, $cardNo, $phoneNo, $month, $year, $cvv, $customerId);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
} 

function postPaymentsInfo()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  var_dump($_POST);
  $nickName        =     $_POST['nickName']; 
  $firstName       =     $_POST['firstName']; 
  $lastName        =     $_POST['lastName']; 
  $shippingId      =     $_POST['shippingAddress']; 
  $paymentAddress  =     $_POST['address']; 
  $postalCode      =     $_POST['postalCode']; 
  $country         =     $_POST['country']; 
  $city            =     $_POST['city']; 
  $cardNo          =     $_POST['cardNo']; 
  $phoneNo         =     $_POST['phone']; 
  $month           =     $_POST['month']; 
  $year            =     $_POST['year']; 
  $cvv             =     $_POST['cvv'];
  $id              =     $_GET['id'];
  $customerId      =     (int)$id;
  
  $updateCustomerPassword = new MyAccountModel();
    try {
        $updateCustomerPassword->insertPaymentsInfos($nickName, $firstName, $lastName, $shippingId, $paymentAddress, $postalCode, $country, $city, $cardNo, $phoneNo, $month, $year, $cvv, $customerId);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
} 

?>