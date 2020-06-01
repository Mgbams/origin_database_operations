<?php
require(__DIR__ . "./../../config/bdd.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
header("Access-Control-Allow-Methods: PUT, GET, POST");
header('Content-Type: multipart/form-data; charset=utf-8');

$postdata = file_get_contents("php://input");
$_POST = json_decode(file_get_contents('php://input'), true);

if(isset($postdata) && !empty($postdata)) {
    $email = $_POST['data'][0]['email'];
        $password = $_POST['data'][1]['password'];
   
    try {
        $pwd = trim($password);
        // $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);
        $email = trim($email);
        $accessBdd = new Bdd();
        $bdd = $accessBdd->getBdd();
        $request = $bdd->prepare("SELECT * FROM customers WHERE email = ?");
        $request->execute(array(
           $email
        ));
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        if (password_verify($pwd, $solution[0]['customer_password'])) {
            $rows = array();
            if ($solution !== false) { 
                $rows = $solution;
            }
            echo json_encode($rows);
        } else {
            var_dump($solution[0]['customer_password']);
        }
      
    } catch(Exception $e) {
        var_dump("Erreur " . $e->getMessage());
    }
   
}
