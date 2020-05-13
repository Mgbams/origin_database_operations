<?php 
require(__DIR__ . "./../../application/models/Category_model.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

putCategory();

function putCategory()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  $name = $_POST['info'][0]['data']['categoryName'];
  $description = $_POST['info'][0]['data']['categoryDescription'];
  $id = $_POST['info'][0]['id'];
  $categoryId = (int)$id;
  
  $updateCategoryModel = new CategoryModel();
    try {
        $updateCategoryModel->updateCategory($name, $description, $categoryId );
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
} 
?>