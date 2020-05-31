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

  public function insertToken($resetEmail, $resetSelector, $resetToken, $resetExpires)
  {
    try {
      $request = $this->bdd->prepare("INSERT INTO `password_reset` (password_reset_email, password_reset_selector, password_reset_token, password_reset_expires) VALUES(?, ?, ? ,?)");

      return $request->execute(array(
        $resetEmail, 
        $resetSelector, 
        $resetToken, 
        $resetExpires
        ));
    } catch (Exception $e) {
         var_dump("Erreur " . $e->getMessage());
       // echo "big error";
    }
  }

  public function getToken($email)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `password_reset` WHERE password_reset_email = ?");
      $request->execute(array(
        $email
      ));
      $solution = $request->fetch(PDO::FETCH_ASSOC);
      // echo json_encode($solution);
      return $solution;
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error during getToken method";
  }
  }

  public function updatePassword($newPassword, $email) {
    try {
      $request = $this->bdd->prepare("UPDATE `customers` 
      SET customer_password = ?, WHERE email = ?"
      );
      $request->execute(array(
        $newPassword,
        $email
      ));
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error during updatePassword method";
  }
  }

}
?>
