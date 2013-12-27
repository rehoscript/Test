<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


     $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\n";
            $headers .= "From: MetaSpace<hola@gmail.com>";
            $headers .= "Reply-To: hola@gmail.com \r\n";

            
            $mensaje = <<<correo
    <html>
    <head>
    <title>Bienvenido a MetaSpace</title>
    </head>
    <body>   
    
    </body>
    </html>
correo;
            $titulo   = 'Comentario'; 
            
            
            $res=mail('rehoscript@gmail.com', $titulo, $mensaje, $headers);
            if($res)
                echo true;
            else
                echo false;
    

?>
