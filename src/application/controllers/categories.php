<?php
require(__DIR__ . "./../models/Category_model.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: Accept,Accept-Language,Content-Language,Content-Type');

getData();

// CRUD OPERATIONS

function getData()
{
  $postCategory = json_decode(file_get_contents('php://input'), true);
  $name = $postCategory['categoryName'];
  $description = $postCategory['categoryDescription'];
    $categoryModel = new CategoryModel();
    try {
        $categoryModel->insertCategory($name, $description);
        echo "Successfully Inserted";
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}
?>
