<?php
require(__DIR__ . "./../../models/forgot-password.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Load Composer's autoloader
require './../../../../vendor/autoload.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include_once "./../../../../vendor/phpmailer/phpmailer/src/PHPMailer.php";
include_once "./../../../../vendor/phpmailer/phpmailer/src/Exception.php";
include_once "./../../../../vendor/phpmailer/phpmailer/src/SMTP.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': // read data
        sendEmail();
        break;
    case 'PUT': // read data
        updateForgottenPassword();
        break;

    default:
        print('{"result": "unsupported request"}');
}

function sendEmail()
{
  $_POST = json_decode(file_get_contents('php://input'), true);
  var_dump($_POST);
  
  $email = $_POST['personalEmail'];
  $booleanResult = validateEmail($email);
  if(!$booleanResult) {
    failedResponse();
  }
  sendLink($email);
}

function validateEmail($data) {
    $forgotPasswordModel = new ForgotPasswordtModel();
    try {
        $resetLink = $forgotPasswordModel->getEmail($data);
        if ($resetLink != false) {
            echo json_encode("Successfully found email");
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        // var_dump("Erreur " . $e->getMessage());
        echo "big error";
    }
}

function failedResponse() {
    echo json_encode("Email does not exist on database");
}

function sendLink($email) {
    // Am using two tokens for this
    // generating random byte of 8 bits and converting it to hexadecimal so it can be useable in links
    $selector = bin2hex(random_bytes(8)); 

    // generating a random token of 32 bits
    // note: i converted it to hex inside url as i want to use this raw form declared here elsewhere in my code

    $token = random_bytes(32);

    // This is the url of my angular page where i will reset the password
    $url = 'http://localhost:8100/reset-password?selector=' . $selector . '&validator=' . bin2hex($token);

    $expires = date("U") + 1800;

    $accessBdd =  new ForgotPasswordtModel();
    $tokenAlreadyExist = $accessBdd->getToken($email);
    if ($tokenAlreadyExist !== false) {
        $accessBdd->deleteToken($email); // Delete previous existing token for this email Address
    }
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    $accessBdd->insertToken($email,  $selector, $hashedToken, $expires);

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
   
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
    $mail->SMTPDebug = 3;                    // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       =  'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'mgbamsstephen@gmail.com';                     // The company address mail
    $mail->Password   = 'iwuchukwu28';                    // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged 
    $mail->Port       = '587';                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    $mail->From =  'origin@thunderbild.com';
    $mail->FromName = 'Mgbams Administrator';  // Name of email sender. It is the left name that appears on received mail
    //Recipients
    $mail->addAddress($email);     // Add address of users. it will appear in Reply-To address
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = '<h2>Reset Your Origin Password</h2>';
    $mail->Body =  "<p>We received a password reset request. The link to reset your password is below.
                     If you did not make this request you can ignore this message. <br /> 
                     Here is your password reset link <br />
                    </p>" . '<a href="' .$url . '">' . $url . '</a>';

    $mail->Mailer = "smtp";
  
    $mail->CharSet = 'utf-8';
    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );

    if($mail->send()) {
        var_dump('reset link successfully sent');
        echo json_encode('reset link successfully sent');
    } else {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        echo json_encode('reset link successfully sent');
    }
}

function updateForgottenPassword() {
    $_POST = json_decode(file_get_contents('php://input'), true);
    var_dump($_POST);
    $newPassword = $_POST['newPassword'];
    // remains to add an email argument into the updatePassword method

    $accessBdd =  new ForgotPasswordtModel();
    $accessBdd->updatePassword($newPassword);
}
