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
  $nom = $_POST['info'][0]['data']['subcategoryName'];
  $desc = $_POST['info'][0]['data']['subcategoryDescription'];
  $id = $_POST['info'][0]['id'];
  $subcategory_id = (int)$id;
  var_dump($nom);
  var_dump($desc);
  var_dump($subcategory_id);
  
  $updateSubCategoryModel = new SubCategoryModel();
    try {
        $updateSubCategoryModel->updateSubCategory($nom, $desc, $subcategory_id);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
}  
?>