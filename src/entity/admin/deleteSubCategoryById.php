<?php
require(__DIR__ . "./../../repository/bdd.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header('Content-Type: multipart/form-data; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'DELETE': // read data
        delData();
        break;

    default:
        print('{"result": "unsupported request"}');
}


// CRUD OPERATIONS

function delData()
{
    $id = $_GET['id'];
    $catId = (int)$id;
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();
    try {
        $request = $bdd->prepare("DELETE FROM subcategory WHERE subcategory_id = ?");
        $request->execute(array(
            $catId
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}