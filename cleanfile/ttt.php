<?php
//UploadImgModel

class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_model');
    }

    public function upload()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");

        $filename = NULL;

        $isUploadError = FALSE;
        $fullPath = '';

        if ($_FILES && $_FILES['productImage']['name']) {

            $config['upload_path']          = './tmp';
            $config['allowed_types']        = 'jpg|jpeg|png|gif';
            $config['max_size']             = 10024;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('productImage')) {

                $isUploadError = TRUE;

                $response = array(
                    'status' => 'error',
                    'message' => $this->upload->display_errors()
                );
            } else {
                $uploadData = $this->upload->data();
                $filename = $uploadData['file_name'];
                $fullPath = base_url('tmp/' . $filename);
            }
        }

        if (!$isUploadError) {

            $response = array(
                'status' => 'success',
                'filename' => $filename,
                'imagePath' => $fullPath
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function deleteImage()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");

        $filename = $this->input->post('filename');
        $filePath = './tmp/' . $filename;

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                $response = array(
                    'status' => 'deleted'
                );
            } else {
                $response = array(
                    'status' => 'not delete'
                );
            }
        } else {
            $response = array(
                'status' => 'file not exist'
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function saveProduct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");

        $productName = $this->input->post('productName');
        $price = $this->input->post('price');
        $sku = $this->input->post('sku');

        if ($productName) {

            $productData = array(
                'product_name' => $productName,
                'price' => $price,
                'sku' => $sku,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s', time())
            );

            $id = $this->api_model->insert_product($productData);

            $tmpDir    = 'tmp';
            $files = scandir($tmpDir);

            $imageData = array();
            foreach ($files as $filename) {

                if (!in_array($filename, array(".", ".."))) {

                    $imageData[] = array(
                        'product_id' => $id,
                        'image' => $filename
                    );

                    rename('tmp/' . $filename, 'uploads/' . $filename);
                }
            }

            if (!empty($imageData)) {
                $this->api_model->insert_product_image($imageData);

                $response = array(
                    'status' => 'success',
                    'message' => 'Product added successfully'
                );
            } else {
                $response = array(
                    'status' => 'error'
                );
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
?>

/*for ($i = 0; $i < count($_FILES['selectedImage']['name']); $i++) {
    $filename = $_FILES['selectedImage']['name'][$i];
    $target_file = $target_dir . $_FILES['selectedImage']['name'][$i];
    move_uploaded_file($_FILES['fileUpload']['tmp_name'][$i], $target_file);

    $uploadImageModel = new UploadImgModel();

try {
    $uploadImageModel->insert_product_image($filename);
    echo "Successfully Inserted";
} catch (Exception $e) {
    // var_dump("Erreur " . $e->getMessage());
    echo "big error";
}
} */



//////////////////////////////////////////////////////////////////////////////////////////

<?php
require(__DIR__ . "./../models/upload_img_model.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
// header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Methods: PUT, GET, POST");
header('Content-Type: multipart/form-data; charset=utf-8');

print_r($_FILES);
// $response = array();
// $target_dir = "./../../assets/images/";
$target_dir = "./../../../uploadedPhotos/";
$server_url = 'http://localhost/origin/src/application/controllers/uploadImg.php';


if($_FILES['productImages'])
{
    
    $filename_tmp_name = $_FILES["productImages"]["tmp_name"];
    $error = $_FILES["productImages"]["error"];
    $filename = $_FILES['productImages']['name'];
    $target_file = $target_dir . $_FILES['productImages']['name'];

    if($error > 0){
        $response = array(
            "status" => "error",
            "error" => true,
            "message" => "Error uploading the file!"
        );
    } else {
        $random_name = rand(1000,1000000)."-".$filename ;
        $upload_name = $target_dir.strtolower($random_name);
        $upload_name = preg_replace('/\s+/', '-', $upload_name);
    
        if(move_uploaded_file($filename_tmp_name, $upload_name)) {
            $response = array(
                "status" => "success",
                "error" => false,
                "message" => "File uploaded successfully",
                "url" => $server_url."/".$upload_name
              );
                    
            $uploadImageModel = new UploadImgModel();

            try {
                $uploadImageModel->insert_product_image($random_name);
            } catch (Exception $e) {
                // var_dump("Erreur " . $e->getMessage());
                echo "big error";
            }
        } else {
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading the file!"
            );
        }
    }
} else {
    $response = array(
        "status" => "error",
        "error" => true,
        "message" => "No file was sent!"
        );
    } 

// echo json_encode($response);








<?php
session_start();

$user = $_SESSION['user'];

if ($user === 'admin') {
    echo '{
        "message": "This is a secret message for an administrator",
        "success": true
    }';
} else {
    echo '{
        "message": "who the fuck are you",
        "success": false
    }';
}


<?php
session_start();

if(isset($_SESSION['user'])) {
    echo '{
        "status": "true";
    }';
} else  {
    echo '{"status": "false"}'
}

?>

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


//////////////// customer authentication


<?php 
session_start();
require(__DIR__ . "./../repository/bdd.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
header("Access-Control-Allow-Methods: PUT, GET, POST");
header('Content-Type: multipart/form-data; charset=utf-8');

$_POST = json_decode(file_get_contents('php://input'), true);
var_dump($_POST);
loginCustomer();

function loginCustomer()
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($email)) {
        if (!empty($email) and !empty($password )) {
            $accessBdd = new Bdd();
            $bdd = $accessBdd->getBdd();
            $request = $bdd->prepare("SELECT * FROM customers WHERE email = ?");
            $request->execute(array(
               $email
            ));
            $solution = $request->fetchAll(PDO::FETCH_ASSOC);
            // echo json_encode($solution);
            $loginDetails= json_encode($solution);
            if ($loginDetails != false) { // That is if there exists a data in the database with the typed in email address
                if (password_verify($password, $solution[0]['customer_password'])) {
                    $_SESSION['email'] = $solution[0]['email'];
                    $_SESSION['firstName'] = $solution[0]['first_name'];
                    $_SESSION['id'] = $solution[0]['customer_id'];
                    echo json_encode($solution);
                    echo 'password and email matched';
                } else {
                    echo "Mauvais mot de passe. Veuillez vérifier votre mot de passe";
                }
            } else {
                echo "Il n'y a aucun utilisateur avec cet e-mail";
            }
        } else if (empty($password) and empty($email)) {// you must first test for both password and email if they are both empty if you want to catch all the errors
            echo "Veuillez saisir un e-mail et un mot de passe pour vous connecter";
        } else if (empty($email)) {
            echo "Veuillez entrer un email";
        } else if (empty($password)) {
            echo "Veuillez entrer un mot de passe";
        }
    }
}


/*
<?php
    $data = $_POST['test'];
    $echo $data;
?>
*/

?>




////// CUSTOMER SIGNIN PAGE 


<?php
session_start();

require(__DIR__ . "./../repository/bdd.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET': // read data
        compareUserMailAndPassword($mail);
        break;

    default:
        print('{"result": "unsupported request"}');
}


// selectionner un utilisateur avec son email et mot de passe pour l'identifier(signin) to cart

function compareUserMailAndPassword($mail)
{
    $accessBdd = new Bdd();
    $bdd = $accessBdd->getBdd();
    try {
        $request = $bdd->prepare("SELECT * FROM customers WHERE email = ?");
        $request->execute(array(
            $mail
        ));
        $solution = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($solution);
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}


   // if (password_verify($_POST['mdp'], $this->loginDetails['passwords'])) {}
?>

<?php

$_POST = json_decode(file_get_contents('php://input'), true);
if(isset($_POST) && !empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === 'king@gmail.com' && $password === "kingking") {
        $_SESSION['user'] = 'admin';
        ?>
        {
            "success": true,
            "secret": "This is the secret no one knows but the admin"
        }
        <?php
        } else {
            ?>
        {
            "success": false,
            "message": "Invalid credentials"
        }
        <?php
        }
    } else {
        ?>
        {
         "success": false,
         "message": "Only POST requests accepted"
        }
        <?php
    }
?>












/////////////////////////////////////////////////////////////////


<?php
session_start();
require(__DIR__ . "./../repository/bdd.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
header("Access-Control-Allow-Methods: PUT, GET, POST");
header('Content-Type: multipart/form-data; charset=utf-8');

$_POST = json_decode(file_get_contents('php://input'), true);
var_dump($_POST);
loginCustomer();

function loginCustomer()
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($email)) {
        if (!empty($email) and !empty($password)) {
            $accessBdd = new Bdd();
            $bdd = $accessBdd->getBdd();
            $request = $bdd->prepare("SELECT * FROM customers WHERE email = ?");
            $request->execute(array(
                $email
            ));
            $solution = $request->fetchAll(PDO::FETCH_ASSOC);
            $loginDetails = json_encode($solution);
            if ($loginDetails != false) { // That is if there exists a data in the database with the typed in email address
                if (password_verify($password, $solution[0]['customer_password'])) {
                    $_SESSION['email'] = $solution[0]['email'];
                    $_SESSION['firstName'] = $solution[0]['first_name'];
                    $_SESSION['id'] = $solution[0]['customer_id'];
                    echo "---------------------------";
                    echo $_SESSION['firstName'];
?>
                    {
                    "details": <?php echo $loginDetails ?>;
                    }
                <?php
                } else {
                ?>
                    {
                    "$error": "Mauvais mot de passe. Veuillez vérifier votre mot de passe";
                    }
                <?php
                }
            } else {
                ?>
                {
                "error": "Il n'y a aucun utilisateur avec cet e-mail";
                }
            <?php
            }
        } else if (empty($password) and empty($email)) { // you must first test for both password and email if they are both empty if you want to catch all the errors
            ?>
            {
            "error": "Mot de passe et email sont vide";
            }
        <?php
        } else if (empty($email)) {
        ?>
            {
            "error": "Veuillez entrer un email";
            }
        <?php
        } else if (empty($password)) {
        ?>
            {
            "error": "Veuillez entrer un mot de passe";
            }
<?php
        }
    }
}
?>
