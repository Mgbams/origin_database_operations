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
  // var_dump($_POST);
  
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
            // echo json_encode("Successfully found email");
            // echo json_encode( $resetLink);
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
    // generating a random token of 32 bits
    // note: i converted it to hex inside url as i want to use this raw form declared here elsewhere in my code

    $token = random_bytes(8);

    // This is the url of my angular page where i will reset the password
    $url = 'http://localhost:8100/reset-password?token=' . bin2hex($token);
    $contactUs = 'http://localhost:8100/contact';   /**  To be updated when i upload my site online */
    $welcomePage  = 'http://localhost:8100/tabs/tab1'; /**  To be updated when i upload my site online */

    $site = 'www.origin.local'; /**  To be updated when i upload my site online */

    $expires = date("U") + 1800; // expires in an hours time
    
    $date = date('Y-m-d H:i:s'); // This is  added to email body to show current time email was sent
    
    $accessBdd =  new ForgotPasswordtModel();
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);

    $accessBdd->updateCustomerToken($hashedToken, $expires, $email);
    $customerInfoWithToken = $accessBdd->getEmail($email);
    echo json_encode($customerInfoWithToken);

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
   
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
    $mail->SMTPDebug = 0;                    // Enable verbose debug output
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
    $mail->Subject = 'Reset Your Origin Password';

     $mail->Body = "<div style='border: 1px solid gray; border-top: 8px solid pink; width: 40vw; margin: auto;'>
                        <div style='border-bottom: 1px solid gray; width: 40vw;'>
                            <div style='display: flex; flex-direction: row; justify-content: space-between; padding: 0px 20px; width: 35vw;'>
                                <div style='width: 8vw;'><p>Origin.com</p></div>
                                <div style='width: 12vw; margin-left: 35%;'><p>Reset Your Password</p></div>
                            </div>
                            <hr style='width: 38vw; margin: 8px auto;'/>
                        </div>
                        <div style='width: 100%; padding: 12px 20px;'>
                            <p>You recently asked to reset your <a href='" . $site. "'>www.origin.local</a> passowrd</p>
                            <p>To continue the password reset process, please proceed to link below.</p>
                            <p style='background-color: yellow; width: 15vw; padding: 6px 0px; text-align: center; font-size: 1rem;'><a href='" .  $url . "' style='text-decoration: none;'><strong>RESET PASSWORD</strong></a></p>
                            <p>This password reset request was made on " . $date . "</p>
                            <p>For security reasons, the password reset link will expire in an hour or after you <br />
                            reset your password.</p>
                            <p><strong>Questions or Comments?</strong></p>
                            <a href='" . $contactUs . "'>Please Contact Us</a>
                        </div>
                    </div>
                    <div style='width: 40vw; margin: auto;'>
                        <hr />
                        <small>This is an automated email. Please do not reply to this email. &copy; origin.com " . date("Y") . "</small> <br />
                        <small style='text-align: center;'>Powered by <a href='" . $welcomePage . "'>Origin.com</a></small>
                    </div>
                    ";

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

    try {
        $resetToken = $_POST['data'][0]['token'];
        $password =  $_POST['data'][0]['password']['newPassword']; 
        $cryptedPassword = password_hash($password, PASSWORD_DEFAULT);
     
        $accessBdd =  new ForgotPasswordtModel();
        $accessBdd->updatePassword($cryptedPassword, $resetToken);
    } catch (Exception $e) {
        var_dump("Erreur " . $e->getMessage());
       // echo "big error";
    }
 
}
