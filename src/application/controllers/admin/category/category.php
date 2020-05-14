<?php
require(__DIR__ . "./../../../models/category.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getCategoryById();
        break;
    case 'PUT': // read data
        putCategory();
        break;
    case 'DELETE': // read data
        deleteCategoryById();
        break;
    case 'POST': // read data
        insertCategory();
        break;

    default:
        print('{"result": "unsupported request"}');
}

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

function deleteCategoryById()
{
    $id = $_GET['id'];
    $categoryId = (int)$id;
    $accessBdd = new CategoryModel();
    try {
        $accessBdd->deleteCategory($categoryId);
    } catch(Exception $e) {
        echo "big error";
    } 
}

function getCategoryById()
{
    $id = $_GET['id'];
    $categoryId = (int)$id;
    $accessBdd = new CategoryModel();
    try {
        $accessBdd->getCategoryById($categoryId);
    } catch(Exception $e) {
        echo "big error";
    }
   
}

function insertCategory()
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