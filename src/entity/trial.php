<?php
require(__DIR__ . "./../repository/bdd.php");
header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Accept, Accept-Language, Origin, User-Agent');
header('Access-Control-Request-Method: POST');
// header('Access-Control-Request-Headers: origin, x-requested-with');

var_dump($_POST); 
$data = json_decode(file_get_contents('php://input'), true);
var_dump($data);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST': // create data

       $data = json_decode(file_get_contents('php://input'), true);
       postData($data);
       var_dump('post');
        break;


    default:
        print('{"result": "unsupported request"}');
}


// CRUD OPERATIONS


function postData($data)
{
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();

    try {
        $nom = $data;

        var_dump($nom);
      //  $request = $bdd->prepare("INSERT INTO test(nom, phone, date_time) VALUES(?, ?, NOW())");

       /* echo $request->execute(array(
            $nom,
            $phone
        )); */
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}










/*
<?php
    $data = $_POST['test'];
    $echo $data;
?>
*/

?>