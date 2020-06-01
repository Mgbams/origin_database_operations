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
      return $solution;
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

  public function deleteToken($email)
  {
    try {
      $request = $this->bdd->prepare("DELETE FROM `password_reset` WHERE password_reset_email = ?");
      $request->execute(array(
        $email
      ));
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error during delete";
  }
  }

  public function updatePassword($newPassword, $resetToken) {
    try {
      $request = $this->bdd->prepare("UPDATE `customers` 
      SET customer_password = ? WHERE password_reset_token = ?"
      );
      $request->execute(array(
        $newPassword,
        $resetToken
      ));
  } catch (Exception $e) {
      var_dump("Erreur " . $e->getMessage());
     // echo "big error during updatePassword method";
  }
  }

  public function updateCustomerToken($resetToken, $resetExpires, $email) {
    try {
      $request = $this->bdd->prepare("UPDATE `customers` 
      SET password_reset_token = ?, password_reset_expires = ? WHERE email = ?"
      );
      $request->execute(array(
        $resetToken, 
        $resetExpires, 
        $email
      ));
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error during updatePassword method";
  }
  }

}
?>
