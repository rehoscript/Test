<?php
$headers .= "Organization: Sender Organization\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
 
  
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
   $headers .= "Reply-To: hectormoralespalma@gmail.com\r\n";
   $headers .= "From: MetaSpace";
    
mail("rehoscript@gmail.com", "Message", "A simple message.", $headers); 


?>
