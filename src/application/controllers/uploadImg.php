











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


if ($_FILES['productImages']) {
    $images_name = "";
    for ($i = 0; $i < count($_FILES['productImages']['name']); $i++) {
        $filename = $_FILES['productImages']['name'][$i];
        $target_file = $target_dir . $_FILES['productImages']['name'][$i];
        $filename_tmp_name = $_FILES["productImages"]["tmp_name"][$i];
        $error = $_FILES["productImages"]["error"][$i];
        


        if ($error > 0) {
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading the file!"
            );
        } else {
            $random_name = rand(1000, 1000000) . "-" . $filename;
            $upload_name = $target_dir . strtolower($random_name);
            $upload_name = preg_replace('/\s+/', '-', $upload_name);
            $images_name = $random_name . "," . $images_name;
            $images_name = rtrim($images_name, ','); // removing trailing comma
            move_uploaded_file($filename_tmp_name, $upload_name);
        }
    }
    if ("" !== $images_name) {
        $response = array(
            "status" => "success",
            "error" => false,
            "message" => "File uploaded successfully",
            "url" => $server_url . "/" . $upload_name
        );

        $uploadImageModel = new UploadImgModel();

        try {
            $uploadImageModel->insert_product_image($images_name);
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
} else {
    $response = array(
        "status" => "error",
        "error" => true,
        "message" => "No file was sent!"
    );
}

// echo json_encode($response);
