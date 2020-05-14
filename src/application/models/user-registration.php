<?php
require(__DIR__ . "./../config/bdd.php");

class UserRegistrationModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function insertUserInfos($firstName, $lastName, $city, $country, $email, $password)
  {
    try {
      $request = $this->bdd->prepare("INSERT INTO customers(first_name, last_name, city, country, email, customer_password) VALUES(?, ?, ?, ?, ?, ?)");

      return $request->execute(array(
        $firstName, 
        $lastName, 
        $city, 
        $country, 
        $email, 
        $password
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }
}
?>
