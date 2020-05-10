<?php
require(__DIR__ . "./../../repository/bdd.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
header("Access-Control-Allow-Methods: PUT, GET, POST");
header('Content-Type: multipart/form-data; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getData();
        break;

    default:
        print('{"result": "unsupported request"}');
}

function getData()
{
    $id = $_GET['id'];
    $catId = (int)$id;
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();
    try {
        $request = $bdd->prepare("SELECT * FROM category WHERE category_id = ?");
        $request->execute(array(
            $catId
        ));
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}