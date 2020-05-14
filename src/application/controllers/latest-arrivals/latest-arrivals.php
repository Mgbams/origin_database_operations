<?php
require(__DIR__ . "./../../models/latest-arrivals.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
header("Access-Control-Allow-Methods: PUT, GET, POST");
header('Content-Type: multipart/form-data; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getLatestArrivals();
        break;

    default:
        print('{"result": "unsupported request"}');
}

function getLatestArrivals()
{
    $accessBdd =  new LatestArrivalsModel();
    $accessBdd->getFeaturedProducts();
}

