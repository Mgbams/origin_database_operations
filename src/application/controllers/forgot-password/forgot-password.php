<?php
require(__DIR__ . "./../../models/forgot-password.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': // read data
        sendEmail();
        break;

    default:
        print('{"result": "unsupported request"}');
}

function sendEmail()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  var_dump($_POST);
  $email = $_POST['email'];
  $booleanResult = validateEmail($email);
  if(!$booleanResult) {
    failedResponse();
  }
  sendLink($email);
}

function validateEmail($data) {
    $forgotPasswordModel = new ForgotPasswordtModel();
    try {
        $resetLink = $forgotPasswordModel->getEmail($data);
        if ($resetLink != false) {
            return true;
        } else {
            return false;
        }
        echo "Successfully Inserted";
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}

function failedResponse() {
    echo json_encode("Email does not exist on database");
}

function sendLink($email) {

}

?>
