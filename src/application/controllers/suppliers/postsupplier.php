<?php
require(__DIR__ . "./../../models/suppliers_model.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: Accept,Accept-Language,Content-Language,Content-Type');

postSupplier();

$postSupplier = json_decode(file_get_contents('php://input'), true);

echo "-------------------";

var_dump($postSupplier);

// CRUD OPERATIONS

function postSupplier()
{
  $postSupplier = json_decode(file_get_contents('php://input'), true);

  $cname = $postSupplier['companyName'];
  $fname = $postSupplier['contactFname'];
  $lname = $postSupplier['contactlname'];
  $title = $postSupplier['contactTitle'];
  $addr = $postSupplier['address'];
  $city = $postSupplier['city'];
  $zip = $postSupplier['postalCode'];
  $country = $postSupplier['country'];
  $phone = $postSupplier['phone'];
  $mail = $postSupplier['email'];
  $cId = $postSupplier['customerId'];
  
  $supplierModel = new SuppliersModel();
    try {
        $supplierModel->insertSupplier($cname, $fname, $lname, $title, $addr, $city, $zip, $country, $phone, $mail, $cId);
        echo "Successfully Inserted";
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}
?>