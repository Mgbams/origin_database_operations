<?php
require(__DIR__ . "./../config/bdd.php");

class UploadImgModel
{
    private $bdd;
    private $accessBdd;

  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function insertProductImages($imageData)
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

 public function getLastImages()
{
    try {
        $request = $this->bdd->prepare("SELECT * FROM product_images ORDER BY image_id DESC LIMIT 1");
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
