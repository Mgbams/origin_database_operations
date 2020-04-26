<?php 
require(__DIR__ . "./../../repository/bdd.php");
require(__DIR__ . "./../models/post_product_model.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: Accept,Accept-Language,Content-Language,Content-Type');

// postProduct();
$newProduct = json_decode(file_get_contents('php://input'), true);
var_dump($newProduct);


// CRUD OPERATIONS

function postProduct()
{
  $newProduct = json_decode(file_get_contents('php://input'), true);

  $pNumber = $newProduct['product_no'];
  $pname = $newProduct['product_name'];
  $pDesc = $newProduct['product_description'];
  $pPrice = $newProduct['product_price'];
  $pDiscount = $newProduct['product_discount'];
  $pFeatured = $newProduct['product_featured'];
  $pSizes = $newProduct['product_sizes'];
  $pColors = $newProduct['product_colors'];
  $pStock = $newProduct['units_in_stock'];
  $pPromo = $newProduct['product_promo'];
  $cId = $newProduct['category_id'];
  $sId = $newProduct['supplier_Id'];

  $suggestedPrice = $newProduct['suggested_sales_prices'];
  $pAvailable = $newProduct['product_available'];
  $unitPrice = $newProduct['unit_price'];
  // $imageId = $newProduct['image_id'];
  // $uOrder = $newProduct['units_on_order']; // It is set to 1 by default during database creation
  // $sId = $newProduct['reorder_level'];     // it is set to 0 by default during database creation

  
  $newProductModel = new PostProductModel();
    try {
        // Connecting to image table to get the last inserted image Id
        $accessBdd = new Bdd();
        $bdd = $accessBdd->getBdd();
        $request = $bdd->prepare("SELECT * FROM product_images ORDER BY image_id DESC LIMIT 1");
        $request->execute();
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        $lastInsertId = $bdd->lastInsertId();
        echo json_encode($solution);

        // Connecting to Products table to insert new products
        $newProductModel->insertProduct($pNumber, $pname, $pDesc, $pPrice, $pDiscount, $pFeatured, $pSizes,  $pColors, $pStock, $pPromo, $cId, $sId, $suggestedPrice, $pAvailable, $unitPrice, $lastInsertId);
        echo "Successfully Inserted";
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}
?>