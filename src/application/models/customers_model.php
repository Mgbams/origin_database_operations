<?php
require(__DIR__ . "./../config/bdd.php");

class CustomersModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  


  public function getCustomers()
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM customers");
      $request->execute();
      $solution = $request->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($solution);
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }


  public function delCustomer($customerId)
{

    try {
        $request = $this->bdd->prepare("DELETE FROM customers WHERE customer_id = ?");
        $request->execute(array(
            $customerId
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}

}
?>
