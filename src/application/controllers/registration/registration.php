<?php
require(__DIR__ . "./../../models/user-registration.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST': // read data
        postUserDatas();
        break;

    default:
        print('{"result": "unsupported request"}');
}


function postUserDatas()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  $email = $_POST["dataInfos"][0]["email"];
  $password = $_POST["dataInfos"][0]["password"];
  $fname = $_POST["dataInfos"][1]["firstName"];
  $lname = $_POST["dataInfos"][1]["lastName"];
  $country = $_POST["dataInfos"][2]["country"];
  $city = $_POST["dataInfos"][2]["state"];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $usersModel = new UserRegistrationModel();
    try {
        $usersModel->insertUserInfos($fname, $lname, $city,  $country, $email, $hashed_password);
        echo "Successfully Inserted";
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}
?>


