<?php
require "thread.php";
require 'PHPMailer-master/class.phpmailer.php';
 

function proceso() {
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
$mail->addAddress('rehoscript2@hotmail.com', 'John Doe');
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
}
 
$thread1 = new Thread('proceso');

 
$thread1->start();

 
while ($thread1->isAlive());
echo "Resultado del hilo 1 (debe ser 3): " . $thread1->getExitCode() . "\n";

?>
 

?>