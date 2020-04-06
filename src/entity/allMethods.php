<?php
require(__DIR__ . "./../Repository/bdd.php");
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST': // create data

        $data = json_decode(file_get_contents('php://input'), true);  // true means you can convert data to array
        //  print_r($data);
        postData($data);
        break;

    case 'GET': // read data
        getData();
        break;

    case 'PUT': // update data
        $data = json_decode(file_get_contents('php://input'), true);  // true means you can convert data to array
        putData($data);
        break;

    case 'DELETE': // delete data
        $data = json_decode(file_get_contents('php://input'), true);  // true means you can convert data to array
        deleteData($data);
        break;

    default:
        print('{"result": "unsupported request"}');
}


// CRUD OPERATIONS

function getData()
{
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();
    try {
        $request = $bdd->prepare("SELECT * FROM test");
        $request->execute();
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}

function postData($data)
{
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();

    try {
        $nom = $data["nom"];
        $phone = $data["phone"];
        $request = $bdd->prepare("INSERT INTO test(nom, phone, date_time) VALUES(?, ?, NOW())");

        echo $request->execute(array(
            $nom,
            $phone
        ));
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}

function deleteData($data)
{
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();
    $id = $data["id"];
    try {
        $request = $bdd->prepare('DELETE FROM test WHERE id = ?');
        $request->execute(array(
            $id
        ));
    } catch (Exception $e) {
        var_dump('Erreur :' . $e->getMessage());
        echo "delete error";
    }
}


function putData($data)
{
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();

    $id = $data["id"];
    $nom = $data["nom"];
    $phone = $data["phone"];

    try {
        $request = $bdd->prepare('UPDATE test SET nom = ?, phone = ?, date_time = NOW() WHERE id = ?');
        $request->execute(array(
            $nom,
            $phone,
            $id
        ));
        echo "successfully inserted data";
    } catch (Exception $e) {
        var_dump('Erreur :' . $e->getMessage());
        echo "erreur during insertion";
    }
}
