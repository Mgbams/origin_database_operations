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
        checkEmailForExistence();
        break;
    case 'PUT': // read data
        updateEmail();
        break;
    default:
        print('{"result": "unsupported request"}');
}

function updateEmail()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
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

function checkEmailForExistence()
{
    $email = $_GET['currentEmail'];
    $id = $_GET['id'];
    $customerId = (int)$id;

    $accessBdd = new MyAccountModel();
    try {
        $solution = $accessBdd->getCustomerEmail($customerId, $email);
        if ($solution != false) { 
            return;
          } else {
            echo json_encode("This Email does not exist for this user");
          }
    } catch(Exception $e) {
        echo "big error";
    }
}

?>