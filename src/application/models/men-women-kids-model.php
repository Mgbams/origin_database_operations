<?php
require(__DIR__ . "./../../repository/bdd.php");

class MenWomenKidsModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function getJeans($categoryName, $subcategoryName)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `products` 
      LEFT JOIN category ON category.category_id = products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
      WHERE category.category_name = ? AND subcategory.subcategory_name  = ?");
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

  
  public function getShorts($categoryName, $subcategoryName)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `products` 
      LEFT JOIN category ON category.category_id = products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
      WHERE category.category_name = ? AND subcategory.subcategory_name  = ?");
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

  public function getShirts($categoryName, $subcategoryName)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `products` 
      LEFT JOIN category ON category.category_id = products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
      WHERE category.category_name = ? AND subcategory.subcategory_name  = ?");
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

  
  public function getSneakers($categoryName, $subcategoryName)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `products` 
      LEFT JOIN category ON category.category_id = products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
      WHERE category.category_name = ? AND subcategory.subcategory_name  = ?");
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

  public function getAccessoires($categoryName, $subcategoryName)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `products` 
      LEFT JOIN category ON category.category_id = products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
      WHERE category.category_name = ? AND subcategory.subcategory_name  = ?");
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

  public function getAllKids($categoryName)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `products` 
      LEFT JOIN category ON category.category_id = products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
      WHERE category.category_name = ?");
      $request->execute(array(
        $categoryName
      ));
      $solution = $request->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($solution);
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

  public function getAllMen($categoryName)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `products` 
      LEFT JOIN category ON category.category_id = products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
      WHERE category.category_name = ?");
      $request->execute(array(
        $categoryName
      ));
      $solution = $request->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($solution);
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

  public function getAllWomen($categoryName)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `products` 
      LEFT JOIN category ON category.category_id = products.category_id
      LEFT JOIN suppliers ON suppliers.supplier_id = products.supplier_id
      LEFT JOIN subcategory ON subcategory.subcategory_id = products.subcategory_id
      WHERE category.category_name = ?");
      $request->execute(array(
        $categoryName
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