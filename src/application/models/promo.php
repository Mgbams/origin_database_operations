<?php
require(__DIR__ . "./../config/bdd.php");

class PromoModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function getAllPromoProducts()
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `origin_products` 
      LEFT JOIN category ON category.category_id = origin_products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = origin_products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = origin_products.subcategory_id
      LEFT JOIN product_images ON product_images.image_id = origin_products.image_id
      WHERE origin_products.product_promo = 1");
      $request->execute();
      $solution = $request->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($solution);
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

  
  public function getSinglePromoProduct()
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `origin_products` 
      LEFT JOIN category ON category.category_id = origin_products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = origin_products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = origin_products.subcategory_id
      WHERE origin_products.product_promo = 1 ORDER BY origin_products.product_id DESC LIMIT 1");
      $request->execute();
      $solution = $request->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($solution);
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }


}
?>