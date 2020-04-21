<?php
require(__DIR__ . "./../models/user-registration-model.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: Accept,Accept-Language,Content-Language,Content-Type');

getData(); // Call the insertion function

// CRUD OPERATIONS

function getData()
{
  $userData = json_decode(file_get_contents('php://input'), true);
  $email = $userData["dataInfos"][0]["email"];
  $password = $userData["dataInfos"][0]["password"];
  $fname = $userData["dataInfos"][1]["firstName"];
  $lname = $userData["dataInfos"][1]["lastName"];
  $country = $userData["dataInfos"][2]["country"];
  $city = $userData["dataInfos"][2]["state"];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $usersModel = new UserRegistrationModel();
    try {
        $usersModel->insertCategory($fname, $lname, $city,  $country, $email, $hashed_password);
        echo "Successfully Inserted";
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}
?>


