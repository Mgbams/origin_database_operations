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
