<?php
require(__DIR__ . "./../../models/suppliers_model.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getData();
        break;
    case 'PUT': // read data
        putSupplier();
        break;
    case 'DELETE': // read data
        deleteSupplier();
        break;

    default:
        print('{"result": "unsupported request"}');
}


// CRUD OPERATIONS

function getData()
{
    $accessBdd =  new SuppliersModel();
    $accessBdd->getSuppliers();
}

function deleteSupplier()
{
    $id = $_GET['id'];
    $supplierId = (int)$id;

    $accessBdd =  new SuppliersModel();
    $accessBdd->delSupplier($supplierId);
}


function putSupplier()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  var_dump($_POST);
  $cnom = $_POST['info'][0]['data']['companyName'];
  $cfname = $_POST['info'][0]['data']['contactFname'];
  $conlname = $_POST['info'][0]['data']['contactlname'];
  $customerId = $_POST['info'][0]['data']['customerId'];
  $contactTitle = $_POST['info'][0]['data']['contactTitle']; 
  $companyAddr = $_POST['info'][0]['data']['address'];
  $city = $_POST['info'][0]['data']['city']; 
  $post = $_POST['info'][0]['data']['postalCode']; 
  $country = $_POST['info'][0]['data']['country']; 
  $phone = $_POST['info'][0]['data']['phone']; 
  $email = $_POST['info'][0]['data']['email'];
  $suppId = $_POST['info'][0]['id'];  

  $supplierId = (int)$suppId;
  
  $updateSupplierModel = new SuppliersModel();
    try {
        $updateSupplierModel->updateSupplier($cnom, $cfname, $conlname, $contactTitle, $companyAddr, $city, $post, $country, $phone, $email, $customerId , $supplierId);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
} 

?>