<?php 
require(__DIR__ . "./models/updateCategoryModel");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: Origin, X-Requested-With,Content-Type,Accept,Authorization,Accept-Language,Content-Language');
header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");

$updateCategoryValues = json_decode(file_get_contents('php://input'), true);
var_dump($updateCategoryValues);
 // putCategory();
 echo "not seeing this page at all";

// CRUD OPERATIONS
/*
function putCategory()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  $nom = $_POST['category_name'];
  $desc = $_POST['category_description'];
  $id = $_GET['id'];
  
  $updateCategoryModelModel = new UpdateCategoryModel();
    try {
        // Connecting to Products table to insert new products
        $updateCategoryModelModel->updateCategory($nom, $desc, $id);
        echo "Successfully Inserted";
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
        // echo "big error";
    }
}  */
?>