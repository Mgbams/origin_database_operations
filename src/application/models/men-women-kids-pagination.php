<?php
require(__DIR__ . "./../config/bdd.php");

class PaginateMenWomenKidsModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
 
public function PaginateMenWomenKidsProducts($page, $numPage, $categoryName)
{
    try {
        $request = $this->bdd->prepare("SELECT * FROM `origin_products` 
        LEFT JOIN category ON category.category_id = origin_products.category_id
        LEFT JOIN suppliers ON suppliers.supplier_id = origin_products.supplier_id
        LEFT JOIN subcategory ON subcategory.subcategory_id = origin_products.subcategory_id
        LEFT JOIN product_images ON product_images.image_id = origin_products.image_id
        WHERE category.category_name = ?
        LIMIT $page, $numPage");
        $request->execute(array(
            $categoryName
        ));
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
}

public function PaginateMenSubcategoryProducts($page, $numPage, $categoryName, $subcategoryName)
{
    try {
        $request = $this->bdd->prepare("SELECT * FROM `origin_products` 
        LEFT JOIN category ON category.category_id = origin_products.category_id
        LEFT JOIN suppliers ON suppliers.supplier_id = origin_products.supplier_id
        LEFT JOIN subcategory ON subcategory.subcategory_id = origin_products.subcategory_id
        LEFT JOIN product_images ON product_images.image_id = origin_products.image_id
        WHERE category.category_name = ? AND subcategory.subcategory_name  = ?
        LIMIT $page, $numPage");
        $request->execute(array(
            $categoryName,
            $subcategoryName
        ));
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
}

}
?>
