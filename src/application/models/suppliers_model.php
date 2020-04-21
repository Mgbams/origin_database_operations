<?php
require(__DIR__ . "./../../repository/bdd.php");

class SuppliersModel
{
    private $bdd;
    private $accessBdd;
  public function __construct()
  {
    $this->accessBdd = new Bdd();
    $this->bdd = $this->accessBdd->getBdd();
  }
  
  public function insertSupplier($cnom, $fname, $lname, $title, $addr, $city, $zip, $country, $phone, $mail, $cId)
  {
    try {
      $request = $this->bdd->prepare(
    "INSERT INTO suppliers(company_name, contact_fname, contact_lname, contact_title, company_address, city, postal_code, country, phone, email, customer_id) 
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

      return $request->execute(array(
        $cnom, 
        $fname, 
        $lname, 
        $title, 
        $addr, 
        $city,  
        $zip, 
        $country, 
        $phone, 
        $mail, 
        $cId
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
  }

}
?>
