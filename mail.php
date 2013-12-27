<?php
require_once 'Swift-5.0.3/lib/swift_required.php';

$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com',
                                              465,
                                              'ssl')
             ->setUsername('hectormoralespalma@gmail.com')
             ->setPassword('maped1819');
 
//Creamos el mailer pasándole el transport con la configuración de gmail
$mailer = Swift_Mailer::newInstance($transport);
 
//Creamos el mensaje
$message = Swift_Message::newInstance($subject)
            ->setFrom(array('rehoscript@gmail.com' => 'Blackslot'))
            ->setTo("rehoscript@gmail.com")
            ->setBody("hola");
 
//Enviamos
echo $result = $mailer->send($message);
    

?>
