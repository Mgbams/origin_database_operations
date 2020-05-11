<?php
require(__DIR__ . "./../repository/bdd.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getLastInsertedImages();
        break;

    default:
        print('{"result": "unsupported request"}');
}

function getLastInsertedImages()
{
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();
    try {
        $request = $bdd->prepare("SELECT * FROM product_images ORDER BY image_id DESC LIMIT 1");
        $request->execute();
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}