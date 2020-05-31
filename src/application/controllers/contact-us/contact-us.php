<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");
header('Access-Control-Allow-Headers: headers,observe,responseType,Accept,Accept-Language, X-Requested-With,Content-Language,Content-Type,Authorization');
header("Access-Control-Allow-Methods: PUT, GET, POST");
header('Content-Type: multipart/form-data; charset=utf-8');

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

// Managing certificate problems

/* use ParagonIE\Certainty\RemoteFetch;

$fetcher = new RemoteFetch('./../../../../vendor/paragonie/certainty/data');
$latestCACertBundle = $fetcher->getLatestBundle();

// $remoteFetch = new RemoteFetch('/var/www/my-project/data/certs');
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_CAINFO, $latestCACertBundle->getFilePath()); */


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$msg = "";


try {
    $_POST = json_decode(file_get_contents('php://input'), true);
    if(!empty($_POST)) {
    var_dump($_POST);
    $subject = $_POST['data'][0]['info']["subject"];
    $email = $_POST['data'][0]['info']["email"];
    $message = $_POST['data'][0]['info']["message"];
    $phone = $_POST['data'][0]['info']["phone"];
    $created_at = date('Y-m-d H:i:s', time());
    var_dump($email);
   
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
    $mail->SMTPDebug = 3;                    // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       =  'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'mgbamsstephen@gmail.com';                     // The company address mail
    $mail->Password   = 'iwuchukwu28';                    // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged 
    $mail->Port       = '587';                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($email, 'Nasir Yagoub');                                         // The customer email
    $mail->addAddress('mgbamsstephen@gmail.com', 'Origin');     // Add origin company email here

    // Content
    $mail->isHTML();                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body =  $message;
    $mail->Mailer = "smtp";
  
    $mail->CharSet = 'utf-8';
    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );

    $mail->send();

    var_dump('message sent');
    }
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>