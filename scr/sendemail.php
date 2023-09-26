<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require '../vendor/autoload.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$userName = $_POST["name"];
$userEmail = $_POST["email"];
$message = $_POST["message"];

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('info.log', Logger::DEBUG));

// add records to the log
$log->info("Name: $userName Email: $userEmail Message: $message");

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'kwiatkowski.maciej22@gmail.com';                     //SMTP username
    $mail->Password   = file_get_contents('../password.txt');                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('kwiatkowski.maciej22@gmail.com', $userEmail);
    $mail->addAddress('40202811@roctilburg.nl');     //Add a recipient

    //Content
    // $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $userEmail;
    $mail->Body    = $message;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    
    // create a log channel
    $error = new Logger('name');
    $error->pushHandler(new StreamHandler('info.log', Level::Warning));
    $error->error($mail->ErrorInfo);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br><br><a href="index.html">terug</a>
</body>
</html>