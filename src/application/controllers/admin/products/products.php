<?php 
require(__DIR__ . "./../../../models/product.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
header("Access-Control-Allow-Methods: PUT, GET, POST");
header('Content-Type: multipart/form-data; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getProductById();
        break;
    case 'PUT': // read data
        putProductById();
        break;
    case 'DELETE': // read data
        deleteProductById();
        break;
    case 'POST': // read data
        postProduct();;
        break;

    default:
        print('{"result": "unsupported request"}');
}

function postProduct()
{
  $newProduct = json_decode(file_get_contents('php://input'), true);
  $productFeatured = null;
  $productPromo = null;
  $productAvailable = null;

  $productNumber = $newProduct[0]['productNumber'];
  $productName = ucfirst($newProduct[0]['productName']);
  $productDescription = ucfirst($newProduct[0]['productDesc']);
  $productPrice = $newProduct[0]['sellingPrice'];
  $productDiscount = $newProduct[0]['productDiscount'];
  $productSizes = strtoupper($newProduct[0]['sizes']);
  $productColors = ucfirst($newProduct[0]['colors']);
  $productInStock = $newProduct[0]['productQty'];
  $customerId = $newProduct[0]['productCategory'];
  $supplierId = $newProduct[0]['productSupplier'];
  $subCategoryId = $newProduct[0]['productSubCategory'];
  $suggestedPrice = $newProduct[0]['costPrice'];
  // $unitPrice = $newProduct[0]['unitPrice'];
  $unitPrice = $newProduct[0]['sellingPrice']; // Same as product price
  $imageId = $newProduct[1]['image_id'];
  $image_id = (int)$imageId;
  if ( $newProduct[0]['productFeatured'] === false) {
    $productFeatured = 0; 
  } else {
    $productFeatured = 1;  
  } 

  if ($newProduct[0]['promo'] === false) {
    $productPromo = 0; 
  } else {
    $productPromo = 1;  
  }

  if ($newProduct[0]['available'] === false) {
    $productAvailable  = 0; 
  } else {
    $productAvailable  = 1;  
  }
  
  
  // $uOrder = $newProduct['units_on_order']; // It is set to 1 by default during database creation
  // $sId = $newProduct['reorder_level'];     // it is set to 0 by default during database creation

  
  $newProductModel = new ProductModel();
    try {
        // Connecting to Products table to insert new products
        $newProductModel->insertProduct($productNumber, $productName, $productDescription, $productPrice, $productDiscount, $productFeatured, $productSizes,  $productColors, $productInStock, $productPromo, $customerId, $supplierId, $suggestedPrice, $productAvailable, $unitPrice, $image_id, $subCategoryId);
        echo "Successfully Inserted";
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
        // echo "big error";
    }
} 

function getProductById() {
  echo  'get';
}

function putProductById() {
  echo 'put';
}

function deleteProductById() {
  echo 'delete';
}

?>