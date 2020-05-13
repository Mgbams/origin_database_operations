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
        deleteData();
        break;

    default:
        print('{"result": "unsupported request"}');
}

function deleteData()
{
    $id = $_GET['id'];
    $catId = (int)$id;
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();
    try {
        $request = $bdd->prepare("DELETE FROM category WHERE category_id = ?");
        $request->execute(array(
            $catId
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}