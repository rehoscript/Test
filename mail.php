<?php
$headers .= "Organization: Sender Organization\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
 
  
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
   $headers .= "Reply-To: hectormoralespalma@gmail.com\r\n";
   $headers .= "From: MetaSpace";
    
mail("enriquegprc@terra.com.mx", "Message", "A simple message.", $headers); 
//require ("PHPMailer-master/class.phpmailer.php");
////require("class.phpmailer.php");
//$mail = new PHPMailer();
//
////Luego tenemos que iniciar la validación por SMTP:
//$mail->IsSMTP();
//$mail->SMTPAuth = true;
//$mail->Host = "smtp.gmail.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
//$mail->Username = "rehoscript@gmail.com"; // Correo completo a utilizar
//$mail->Password = "crackdown2"; // Contraseña
//$mail->Port = 25; // Puerto a utilizar
//
////Con estas pocas líneas iniciamos
//// una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
//$mail->From = "hectormoralespalma@gmail.com"; // Desde donde enviamos (Para mostrar)
//$mail->FromName = "Nombres";
//
////Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
//$mail->AddAddress("correo"); // Esta es la dirección a donde enviamos
//$mail->IsHTML(true); // El correo se envía como HTML
//$mail->Subject = "Titulo"; // Este es el titulo del email.
//$body = "Hola mundo. Esta es la primer línea<br />";
//$body .= "Acá continuo el <strong>mensaje</strong>";
//$mail->Body = $body; // Mensaje a enviar
//$exito = $mail->Send(); // Envía el correo.
//
////También podríamos agregar simples verificaciones para saber si se envió:
//if($exito){
//echo "El correo fue enviado correctamente.";
//}else{
//echo "Hubo un inconveniente. Contacta a un administrador.";
//}
?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PHPMailer - SMTP test</title>
</head>
<body>
<?php

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require "PHPMailer-master/PHPMailerAutoload.php";

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "smtp.gmail.com";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port =  587;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "rehoscript@gmail.com";
//Password to use for SMTP authentication
$mail->Password = "crackdown2";

$mail->SMTPSecure = "tls";
//Set who the message is to be sent from
//$mail->setFrom('hectormoralespalma@gmail.com', 'First Last');
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress('enriquegprc@terra.com.mx', 'John Doe');
//Set the subject line
$mail->Subject = 'PHPMailer SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
$mail->Body ="aa"; 
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.gif');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
?>
</body>
</html>