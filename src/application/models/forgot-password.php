<?php
require(__DIR__ . "./../config/bdd.php");

class ForgotPasswordtModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function insertPassword($password, $email)
  {
    try {
      $request = $this->bdd->prepare("INSERT INTO customers(password, email) VALUES(?) WHERE email = ?");

      return $request->execute(array(
         $password,
         $email
        ));
    } catch (Exception $e) {
         var_dump("Erreur " . $e->getMessage());
       // echo "big error";
    }
  }

  public function getEmail($email)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM customers WHERE email = ?");
      $request->execute(array(
        $email
      ));
      $solution = $request->fetch(PDO::FETCH_ASSOC);
      echo json_encode($solution);
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

}
?>
