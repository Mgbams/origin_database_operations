<?php
require(__DIR__ . "./../config/bdd.php");

class CategoryModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function insertCategory($name, $description)
  {
    try {
      $request = $this->bdd->prepare("INSERT INTO category(category_name, category_description) VALUES(?, ?)");

      return $request->execute(array(
        $name, 
        $description
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }

  public function updateCategory($name, $description, $categoryId)
  {
    try {
      $request = $this->bdd->prepare("UPDATE category
      SET category_name = ?, category_description = ?
      WHERE category_id = ?");

      $request->execute(array(
        $name, 
        $description, 
        $categoryId
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }

  public function deleteCategory($categoryId)
{
    try {
        $request = $this->bdd->prepare("DELETE FROM category WHERE category_id = ?");
        $request->execute(array(
          $categoryId
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}

public function getCategoryById($categoryId)
{
    try {
        $request = $this->bdd->prepare("SELECT * FROM category WHERE category_id = ?");
        $request->execute(array(
            $categoryId
        ));
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
   }   
}


public function retrieveAllCategories()
{
    try {
        $request = $this->bdd->prepare("SELECT * FROM category");
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
