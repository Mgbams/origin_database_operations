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
        updateEmail();
        break;
    default:
        print('{"result": "unsupported request"}');
}

function updateEmail()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  var_dump($_POST);
  var_dump($_GET['id']);
  var_dump($_POST['newEmail']);
  $email = $_POST['newEmail'];
  $id = $_GET['id'];
  $customerId = (int)$id;
  
  $updateCustomerEmail = new MyAccountModel();
    try {
        $updateCustomerEmail->updateEmail($email, $customerId);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
} 

?>