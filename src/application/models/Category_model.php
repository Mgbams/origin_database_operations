<?php
require(__DIR__ . "./../../repository/bdd.php");

class CategoryModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function insertCategory($nom, $desc)
  {
    try {
      $request = $this->bdd->prepare("INSERT INTO category(category_name, category_description) VALUES(?, ?)");

      return $request->execute(array(
            $nom,
            $desc
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }

  public function updateCategory($nom, $desc, $id)
  {
    try {
      $request = $this->bdd->prepare("UPDATE category
      SET category_name = ?, category_description = ?
      WHERE category_id = ?");

      $request->execute(array(
            $nom,
            $desc,
            $id
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }
}
?>
