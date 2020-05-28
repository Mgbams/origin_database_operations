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
        checkPasswordForExistence();
        break;
    case 'PUT': // read data
        updatePassword();
        break;
    default:
        print('{"result": "unsupported request"}');
}

function updatePassword()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
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

function checkPasswordForExistence()
{
  $password = $_GET['currentPassword'];
  $id = $_GET['id'];
  $customerId = (int)$id;
  // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $accessBdd = new MyAccountModel();
    try {
        $solution = $accessBdd->getCustomerPassword($customerId, $password);
        if (password_verify($password, $solution[0]['customer_password'])) {
            if ($solution !== false) {
                return;
            }
        } else {
            echo json_encode("This password does not exist for this user");
        }
    } catch(Exception $e) {
        echo "big error";
    }
}

?>