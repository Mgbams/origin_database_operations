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
        updatePassword();
        break;
    default:
        print('{"result": "unsupported request"}');
}

function updatePassword()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  var_dump($_POST);
  var_dump($_GET['id']);
  var_dump($_POST['newPassword']);
  $password = $_POST['newPassword'];
  $id = $_GET['id'];
  $customerId = (int)$id;
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  
  $updateCustomerPassword = new MyAccountModel();
    try {
        $updateCustomerPassword->updatePassword($hashed_password, $customerId);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
} 

?>