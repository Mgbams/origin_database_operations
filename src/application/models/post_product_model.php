<?php
require(__DIR__ . "./../../repository/bdd.php");

class PostProductModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function insertProduct($pNumber, $pname, $pDesc, $pPrice, $pDiscount, $pFeatured, $pSizes,  $pColors, $pStock, $pPromo, $cId, $sId, $suggestedPrice, $pAvailable, $unitPrice, $imageId, $subCategoryId)
  {
    try {
      $request = $this->bdd->prepare("INSERT INTO error(product_no, product_name, product_description, product_price, product_discount, product_featured, product_sizes, product_colors, units_in_stock, product_promo, category_id, supplier_id, cost_price, available, unit_price, image_id, subcategory_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

      return $request->execute(array(
        $pNumber, 
        $pname, 
        $pDesc, 
        $pPrice, 
        $pDiscount, 
        $pFeatured, 
        $pSizes, 
        $pColors,
        $pStock, 
        $pPromo, 
        $cId, 
        $sId, 
        $suggestedPrice, 
        $pAvailable, 
        $unitPrice,
        $imageId,
        $subCategoryId
        ));
    } catch (Exception $e) {
         var_dump("Erreur " . $e->getMessage());
       // echo "big error";
    }
  }

}
?>
