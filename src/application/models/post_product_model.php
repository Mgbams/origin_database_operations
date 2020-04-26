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
  
  public function insertProduct($pNumber, $pname, $pDesc, $pPrice, $pDiscount, $pFeatured, $pSizes,  $pColors, $pStock, $pPromo, $cId, $sId, $suggestedPrice, $pAvailable, $unitPrice, $imageId)
  {
    try {
      $request = $this->bdd->prepare("INSERT INTO error() VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

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
        $imageId
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }

}
?>
