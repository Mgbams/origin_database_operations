<?php
require(__DIR__ . "./../models/sub-category-model.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: Accept,Accept-Language,Content-Language,Content-Type');

insertData();

// CRUD OPERATIONS

function insertData()
{
  $postCategory = json_decode(file_get_contents('php://input'), true);
  $name = $postCategory['subcategoryName'];
  $description = $postCategory['subcategoryDescription'];
    $categoryModel = new SubCategoryModel();
    try {
        $categoryModel->insertSubCategory($name, $description);
        echo "Successfully Inserted";
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}
?>
