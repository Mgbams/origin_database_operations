<?php
require(__DIR__ . "./../config/bdd.php");

class ProductModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function insertProduct($productNumber, $productName, $productDesc, $productPrice, $productDiscount, $productFeatured, $productSizes,  $productColors, $productStock, $productPromo, $customerId, $supplierId, $suggestedPrice, $productAvailable, $unitPrice, $imageId, $subCategoryId)
  {
    try {
      $request = $this->bdd->prepare("INSERT INTO origin_products(product_no, product_name, product_description, product_price, product_discount, product_featured, product_sizes, product_colors, units_in_stock, product_promo, category_id, supplier_id, cost_price, available, unit_price, image_id, subcategory_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

      return $request->execute(array(
        $productNumber, 
        $productName, 
        $productDesc, 
        $productPrice, 
        $productDiscount, 
        $productFeatured, 
        $productSizes,  
        $productColors, 
        $productStock, 
        $productPromo, 
        $customerId, 
        $supplierId, 
        $suggestedPrice, 
        $productAvailable, 
        $unitPrice, 
        $imageId, 
        $subCategoryId
        ));
    } catch (Exception $e) {
         var_dump("Erreur " . $e->getMessage());
       // echo "big error";
    }
  }

  public function getAllProducts()
  {
    try {
        $request = $this->bdd->prepare("SELECT * FROM `origin_products` 
        LEFT JOIN category ON category.category_id = origin_products.category_id
        LEFT JOIN suppliers ON suppliers.supplier_id = origin_products.supplier_id
        LEFT JOIN subcategory ON subcategory.subcategory_id = origin_products.subcategory_id
        LEFT JOIN product_images ON product_images.image_id = origin_products.image_id
        ");
        $request->execute();
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }

  }

  public function getProductById($id)
  {
    try {
        $request = $this->bdd->prepare("SELECT * FROM `origin_products` 
        LEFT JOIN category ON category.category_id = origin_products.category_id
        LEFT JOIN suppliers ON suppliers.supplier_id = origin_products.supplier_id
        LEFT JOIN subcategory ON subcategory.subcategory_id = origin_products.subcategory_id
        LEFT JOIN product_images ON product_images.image_id = origin_products.image_id
        WHERE origin_products.product_id = ?
        ");
        $request->execute(array(
          $id
        ));
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }

  }


  public function updateProduct($productNumber, $productName, $productDesc, $productPrice, $productDiscount, $productFeatured, $productSizes,  $productColors, $productStock, $productPromo, $categoryId, $supplierId, $suggestedPrice, $productAvailable, $unitPrice, $subCategoryId , $productId)
  {
    try {
      $request = $this->bdd->prepare("UPDATE `origin_products`
      SET product_no = ?, product_name =?, product_description = ?, product_price = ?, product_discount = ?, product_featured = ?, product_sizes = ?, product_colors = ?, units_in_stock = ?, product_promo = ?, category_id = ?, supplier_id = ?, cost_price = ?, available = ?, unit_price = ?, subcategory_id = ?
      WHERE origin_products.product_id = ?");

      $request->execute(array(
        $productNumber, 
        $productName, 
        $productDesc, 
        $productPrice, 
        $productDiscount, 
        $productFeatured, 
        $productSizes,  
        $productColors, 
        $productStock, 
        $productPromo, 
        $categoryId, 
        $supplierId, 
        $suggestedPrice, 
        $productAvailable, 
        $unitPrice, 
        $subCategoryId,
        $productId
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }

  public function deleteProduct($productId)
 {
    try {
        $request = $this->bdd->prepare("DELETE FROM `origin_products` WHERE product_id = ?");
        $request->execute(array(
          $productId
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
 }

 public function PaginateProducts($page, $numPage)
 {
    try {
        $request = $this->bdd->prepare("SELECT * FROM `origin_products` 
        LEFT JOIN category ON category.category_id = origin_products.category_id
        LEFT JOIN suppliers ON suppliers.supplier_id = origin_products.supplier_id
        LEFT JOIN subcategory ON subcategory.subcategory_id = origin_products.subcategory_id
        LEFT JOIN product_images ON product_images.image_id = origin_products.image_id
        LIMIT $page, $numPage");
        $request->execute();
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
 }

}
?>
