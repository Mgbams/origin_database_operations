<?php
require(__DIR__ . "./../config/bdd.php");

class SubCategoryModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function insertSubCategory($name, $description)
  {
    try {
      $request = $this->bdd->prepare("INSERT INTO subcategory(subcategory_name, subcategory_description) VALUES(?, ?)");

      return $request->execute(array(
        $name, 
        $description
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }

    
  public function updateSubCategory($name, $description, $subcategoryId)
  {
    try {
      $request = $this->bdd->prepare("UPDATE subcategory
      SET subcategory_name = ?, subcategory_description = ?
      WHERE subcategory_id = ?");

      $request->execute(array(
        $name, 
        $description, 
        $subcategoryId
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }
}


?>



