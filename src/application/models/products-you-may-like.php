<?php
require(__DIR__ . "./../config/bdd.php");

class ProductsYouMayLikeModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  

public function getSuggestedProducts($categoryName, $subcategoryName)
{
    try {
        $request = $this->bdd->prepare("SELECT * FROM `origin_products` 
        LEFT JOIN category ON category.category_id = origin_products.category_id
        LEFT JOIN suppliers ON suppliers.supplier_id = origin_products.supplier_id
        LEFT JOIN subcategory ON subcategory.subcategory_id = origin_products.subcategory_id
        LEFT JOIN product_images ON product_images.image_id = origin_products.image_id
        WHERE category.category_name = ? AND subcategory.subcategory_name = ?
        ORDER BY category.category_name DESC LIMIT 8
        ");
        $request->execute(array(
            $categoryName, 
            $subcategoryName
        ));
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
   }   
}

}
?>
