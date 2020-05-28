<?php
require(__DIR__ . "./../config/bdd.php");

class MyAccountModel
{
    private $bdd;
    private $accessBdd;

  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function updatePassword($password, $customer_id)
  {
    try {
      $request = $this->bdd->prepare("UPDATE `customers` SET customer_password = ? WHERE customer_id = ?");
      $request->execute(array(
        $password, 
        $customer_id
      ));
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

  public function updateEmail($email, $customer_id)
  {
    try {
      $request = $this->bdd->prepare("UPDATE `customers` SET email = ? WHERE customer_id = ?");
      $request->execute(array(
        $email, 
        $customer_id
      ));
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

  public function getCustomerEmail($id, $email)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM customers WHERE customer_id = ? AND email = ?");
      $request->execute(array(
        $id,
        $email
      ));
      $solution = $request->fetchAll(PDO::FETCH_ASSOC);
      return $solution;
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

  public function getCustomerPassword($id)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM customers WHERE customer_id = ?");
      $request->execute(array(
        $id
      ));
      $solution = $request->fetchAll(PDO::FETCH_ASSOC);
     // echo json_encode($solution);
     return $solution;
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

}
?>
