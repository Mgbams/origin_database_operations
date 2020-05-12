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


function getData()
{
    $accessBdd =  new SuppliersModel();
    $accessBdd->getSuppliers();
}

function deleteSupplier()
{
    $id = $_GET['id'];
    $supplier_id = (int)$id;

    $accessBdd =  new SuppliersModel();
    $accessBdd->deleteSupplier($supplier_id);
}


function putSupplier()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  var_dump($_POST);
  $company_name = $_POST['info'][0]['data']['companyName'];
  $contact_first_name = $_POST['info'][0]['data']['contactFname'];
  $contact_last_name = $_POST['info'][0]['data']['contactlname'];
  $customer_id = $_POST['info'][0]['data']['customerId'];
  $contact_title = $_POST['info'][0]['data']['contactTitle']; 
  $company_address = $_POST['info'][0]['data']['address'];
  $city = $_POST['info'][0]['data']['city']; 
  $post = $_POST['info'][0]['data']['postalCode']; 
  $country = $_POST['info'][0]['data']['country']; 
  $phone = $_POST['info'][0]['data']['phone']; 
  $email = $_POST['info'][0]['data']['email'];
  $supp_id = $_POST['info'][0]['id'];  

  $supplier_id = (int)$supp_id;
  
  $update_supplier_model = new SuppliersModel();
    try {
        $update_supplier_model->updateSupplier($company_name,  $contact_first_name, $contact_last_name, $contact_title, $company_address, $city, $post, $country, $phone, $email, $customer_id, $supplier_id);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
} 

?>