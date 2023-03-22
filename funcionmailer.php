<?php
if($_SERVER['REQUEST_METHOD'] != 'POST' )
/*header("Location: index.html" );*/
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'credential.php';

//Variables para correo
$mensaje  =$_POST['mensaje'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$asunto = $_POST['asunto'];
//$mensaje = $_POST['mensaje'];
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = TITANID;                     //SMTP username
    $mail->Password   = PUENTE;                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


    //Recibidor 
    $mail->setFrom( $email," $nombre");
    $mail->addAddress('clinicafatima@clinicamedicafatima.com.mx');                                                             //Name is optional
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Solicitud de cita';
    $mail->CharSet ='utf-8';
    $mensaje = strip_tags($_POST['mensaje'],$allowedTags);
    $mail->msgHTML('$mensaje');
    $mail->Body = html_entity_decode ("Nombre: $nombre <br>Email: $email <br>Mensaje: $mensaje ");
    $mail->AltBody = ("Email:$email");
// contenido enviado con mensaje 
    $mail->send();
   header("Location: index.html");
} catch (Exception $e) {
    echo "Mensaje no enviado. Mailer Error: {$mail->ErrorInfo}";
}
    /*header("Location: index.html");*/
?>