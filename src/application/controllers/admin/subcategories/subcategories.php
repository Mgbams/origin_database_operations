<?php
require(__DIR__ . "./../../../models/sub-category.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getSubCategoryById();
        break;
    case 'PUT': // read data
        putSubCategory();
        break;
    case 'DELETE': // read data
        deleteSubCategoryById();
        break;
    case 'POST': // read data
        insertSubCategory();
        break;

    default:
        print('{"result": "unsupported request"}');
}

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

function deleteSubCategoryById()
{
    $id = $_GET['id'];
    $subCategoryId = (int)$id;
    $accessBdd = new SubCategoryModel();

    try {
        $accessBdd->deleteSubCategory($subCategoryId);
    } catch(Exception $e) {
        echo "big error";
    } 
}

function getSubCategoryById()
{
    $id = $_GET['id'];
    $subCategoryId = (int)$id;
    $accessBdd = new SubCategoryModel();
    try {
        $accessBdd->retrieveSubCategoryById($subCategoryId);
    } catch(Exception $e) {
        echo "big error";
    }
   
}

function insertSubCategory()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  $name = $_POST['subcategoryName'];
  $description = $_POST['subcategoryDescription'];
    $subCategoryModel = new SubCategoryModel();
    try {
        $subCategoryModel->insertSubCategory($name, $description);
        echo "Successfully Inserted";
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}

?>