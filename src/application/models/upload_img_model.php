<?php
require(__DIR__ . "./../../repository/bdd.php");

class UploadImgModel
{
    private $bdd;
    private $accessBdd;

  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function insert_product_image($imageData)
  {
    try {
      $request = $this->bdd->prepare("INSERT INTO product_images(image) VALUES(?)");

      return $request->execute(array(
        $imageData
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }

}
?>
