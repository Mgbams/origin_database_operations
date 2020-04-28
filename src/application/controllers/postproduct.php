<?php 
require(__DIR__ . "./../models/post_product_model.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
header("Access-Control-Allow-Methods: PUT, GET, POST");
header('Content-Type: multipart/form-data; charset=utf-8');

postProduct();
$newProduct = json_decode(file_get_contents('php://input'), true);
var_dump($newProduct);

// CRUD OPERATIONS

function postProduct()
{
  $newProduct = json_decode(file_get_contents('php://input'), true);
  $pFeatured = null;
  $pPromo = null;
  $pAvailable = null;

  $pNumber = $newProduct[0]['productNumber'];
  $pname = ucfirst($newProduct[0]['productName']);
  $pDesc = ucfirst($newProduct[0]['productDesc']);
  $pPrice = $newProduct[0]['sellingPrice'];
  $pDiscount = $newProduct[0]['productDiscount'];
  $pSizes = strtoupper($newProduct[0]['sizes']);
  $pColors = ucfirst($newProduct[0]['colors']);
  $pStock = $newProduct[0]['productQty'];
  $cId = $newProduct[0]['productCategory'];
  $sId = $newProduct[0]['productSupplier'];
  $suggestedPrice = $newProduct[0]['costPrice'];
  $unitPrice = $newProduct[0]['unitPrice'];
  $imageId = $newProduct[1]['image_id'];
  $image_id = (int)$imageId;
  if ( $newProduct[0]['productFeatured'] === false) {
    $pFeatured = 0; 
  } else {
    $pFeatured = 1;  
  } 

  if ($newProduct[0]['promo'] === false) {
    $pPromo = 0; 
  } else {
    $pPromo = 1;  
  }

  if ($newProduct[0]['available'] === false) {
    $pAvailable  = 0; 
  } else {
    $pAvailable  = 1;  
  }
  
  echo "............To be inserted................";
  var_dump($image_id);
  var_dump($pAvailable);
  var_dump($pPromo);
  var_dump($pFeatured);
  
  // $uOrder = $newProduct['units_on_order']; // It is set to 1 by default during database creation
  // $sId = $newProduct['reorder_level'];     // it is set to 0 by default during database creation

  
  $newProductModel = new PostProductModel();
    try {
        // Connecting to Products table to insert new products
        $newProductModel->insertProduct($pNumber, $pname, $pDesc, $pPrice, $pDiscount, $pFeatured, $pSizes,  $pColors, $pStock, $pPromo, $cId, $sId, $suggestedPrice, $pAvailable, $unitPrice, $image_id);
        echo "Successfully Inserted";
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
        // echo "big error";
    }
} 
?>