<?php 
require(__DIR__ . "./../../application/models/Category_model.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$updateCategoryValues = json_decode(file_get_contents('php://input'), true);
var_dump($updateCategoryValues);
 putCategory();
 echo "not seeing this page at all";

function putCategory()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  $nom = $_POST['info'][0]['data']['categoryName'];
  $desc = $_POST['info'][0]['data']['categoryDescription'];
  $id = $_POST['info'][0]['id'];
  $category_id = (int)$id;
  
  $updateCategoryModelModel = new CategoryModel();
    try {
        $updateCategoryModelModel->updateCategory($nom, $desc, $category_id);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
} 
?>