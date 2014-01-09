<?php

date_default_timezone_set('Etc/UTC');
require "PHPMailer-master/PHPMailerAutoload.php";

class Correo  {

    
//Create a new PHPMailer instance
public $mail;



    public function __construct($destina) {
        
        $this->mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$this->mail->isSMTP();
$this->mail->Debugoutput = 'html';
$this->mail->Host = "smtp.gmail.com";
$this->mail->Port =  587;
$this->mail->SMTPAuth = true;
$this->mail->Username = "rehoscript@gmail.com";
$this->mail->Password = "crackdown2";
$this->mail->isHTML(true);
$this->mail->SMTPSecure = "tls";
$this->mail->setFrom('rehoscript@gmail.com', 'First Last');
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
//$mail->addAddress('enriquegprc@terra.com.mx', 'John Doe');
$this->mail->addAddress('rehoscript2@hotmail.com', 'John Doe');
//Set the subject line
$this->mail->Subject = 'ASUNTO';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

//Replace the plain text body with one created manually

$this->mail->Body ="<h1>aaa<h1>";
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.gif');

//send the message, check for errors
       
    }

    public function run() {
            if (!$this->mail->send() ) {
                echo "Mailer Error: " . $this->mail->ErrorInfo;
            } else {
                echo "Message sent!";
            }
    }

}
$a= new Correo();
$a->run();



