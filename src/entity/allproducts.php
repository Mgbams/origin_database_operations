<?php
require(__DIR__ . "./../repository/bdd.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        getData();
        break;

    default:
        print('{"result": "unsupported request"}');
}


// CRUD OPERATIONS

function getData()
{
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();
    /*try {
        $request = $bdd->prepare("SELECT * FROM products ORDER BY product_id DESC");
        $request->execute();
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }*/

    try {
        $request = $bdd->prepare("SELECT * FROM `origin_products` 
        LEFT JOIN category ON category.category_id = origin_products.category_id
        LEFT JOIN suppliers ON suppliers.supplier_id = origin_products.supplier_id
        LEFT JOIN subcategory ON subcategory.subcategory_id = origin_products.subcategory_id
        LEFT JOIN product_images ON product_images.image_id = origin_products.image_id
        ");
        $request->execute();
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}


/*
// This function should be used to replace the one above
// CRUD OPERATIONS

function getData()
{
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();
    try {
        $request = $bdd->prepare("
            SELECT * FROM `products` 
            LEFT JOIN suppliers ON products.supplier_id = suppliers.supplier_id
            LEFT JOIN category ON products.category_id = category.category_id
            LEFT JOIN product_images ON products.image_id = product_images.image_id");
        $request->execute();
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }


*/