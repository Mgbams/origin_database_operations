<?php
require(__DIR__ . "./../../repository/bdd.php");

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
      $request = $this->bdd->prepare("SELECT * FROM `products` 
      LEFT JOIN category ON category.category_id = products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
      WHERE products.product_promo = 1");
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
      $request = $this->bdd->prepare("SELECT * FROM `products` 
      LEFT JOIN category ON category.category_id = products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
      WHERE products.product_promo = 1 ORDER BY products.product_id DESC LIMIT 1");
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

SELECT * FROM `error` 
      LEFT JOIN category ON category.category_id = error.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = error.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = error.subcategory_id
      WHERE error.product_promo = 1 ORDER BY error.product_id DESC LIMIT 1;