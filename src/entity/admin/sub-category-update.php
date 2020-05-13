<?php 
require(__DIR__ . "./../../application/models/sub-category-model.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

 putSubCategory();

function putSubCategory()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  $name = $_POST['info'][0]['data']['subcategoryName'];
  $description = $_POST['info'][0]['data']['subcategoryDescription'];
  $id = $_POST['info'][0]['id'];
  $subcategoryId = (int)$id; // converting id to integer type using type casting
  
  $updateSubCategoryModel = new SubCategoryModel();
    try {
        $updateSubCategoryModel->updateSubCategory($name, $description, $subcategoryId);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
}  
?>