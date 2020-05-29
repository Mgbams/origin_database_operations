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

  public function updatePaymentsInfos($nickName, $firstName, $lastName, $shippingId, $paymentAddress, $postalCode, $country, $city, $cardNo, $phoneNo, $month, $year, $cvv, $customerId)
  {
    try {
      $request = $this->bdd->prepare("UPDATE `payment_cards` 
      SET card_nickname = ? first_name = ? last_name = ? shipping_id = ? payment_address = ? 
      postal_code = ? country = ? city = ? card_no = ? phone_no = ?
      expire_month = ? expire_year = ? cvv = ? WHERE customer_id = ?"
      );
      $request->execute(array(
        $nickName, 
        $firstName, 
        $lastName, 
        $shippingId, 
        $paymentAddress, 
        $postalCode, 
        $country, 
        $city, 
        $cardNo, 
        $phoneNo, 
        $month, 
        $year, 
        $cvv,
        $customerId
      ));
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

  public function updateShippingAddress($firstName, $lastName, $country, $shippingAddr, $postalCode, $city, $phoneNo, $customerId)
  {
    try {
      $request = $this->bdd->prepare("UPDATE `shipping_address` 
      SET first_name = ? last_name = ? country = ? shipping_address = ? 
      postal_code = ? city = ? phone_no = ? WHERE customer_id = ?");
      $request->execute(array(
        $firstName, 
        $lastName, 
        $country, 
        $shippingAddr, 
        $postalCode, 
        $city, 
        $phoneNo, 
        $customerId
      ));
  } catch (Exception $e) {
      // var_dump("Erreur " . $e->getMessage());
      echo "big error";
  }
  }

  public function getShippingAddressById($id)
  {
    try {
      $request = $this->bdd->prepare("SELECT * FROM `shipping_address` WHERE customer_id = ?");
      $request->execute(array(
        $id
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
