<?php
/**
 *
 * @author e-israel from TERACOM.mx
 * Copyrigth 2010
 *
 */
if(version_compare(PHP_VERSION, "5.2", '<')) die("<p>La versi&oacute;n PHP del servidor es [".PHP_VERSION."]; para un correcto funcionamiento es necesario actualizar a una versi&oacute 5.2 o posterior.</p>");
if(!extension_loaded("mysql"))die("<p>No existe ninguna conexion PHP - MySQL, esta conexi&oacute;n debe existir para un correcto funcionamiento.</p>");

class E
{
    ##die(E::error_mysql(mysqli_connect_errno(),mysqli_connect_error(),__FILE__,__LINE__,__CLASS__,__FUNCTION__,__METHOD__,$_SERVER['PHP_SELF'],$this->sql));
    static function error_mysql($noError, $error, $archivo, $linea, $clase, $funcion, $metodo, $script, $sql)
    {
        echo "<h1>Bueno, esto es vergonzoso.</h1>";
        switch($noError)
        {
            case 1045:#error al conectar con la base de datos
                print("<h3>Error al conectar con la base de datos &quot;".MYSQL_NAME."&quot;.</h3>
                <p>Verifica que las siguientes sugerencias se encuentren configuradas correctamente en el archivo <code>config.php</code>.</p>
                <ul>
                    <li>Tu nombre de usuario y contrase&ntilde; est&aacute;n correctamente escritos?</li>
                    <li>El nombre del host est&aacute; correctamente escrito?</li>
                    <li>El servidor de base de datos, est&aacute; correindo y escuchando por su puerto?</li>
                </ul>
                <p>Si el problema persiste, por favor escribe a <code>soporte@teracom.mx</code> en donde obtendr&aacute;s m&aacute;s informaci&oacute;n</p>");
            break;
            case 1064://error de sintaxis
            case 1049://error al seleccionar la BD
                print("<h3>No es posible seleccionar la base de datos &quot;".MYSQL_NAME."&quot;.</h3>
                        <p>Verifica que las siguientes sugerencias se encuentren configuradas correctamente en el archivo <code>config.php</code>.</p>
                        <ul>
                            <li>El nombre de la base de datos est&aacute; escrito correctamente?</li>
                            <li>Existe la base de datos?</li>
                        </ul>
                        <p>Si el problema persiste, por favor escribe a <code>soporte@teracom.mx</code> en donde obtendr&aacute;s m&aacute;s informaci&oacute;n</p>");
            break;
            case 1146:
            case 0:
            default:
                print ("<p>Ocurri&oacute; un error. Es todo lo que sabemos.</p>
                        <p>En estos momentos nuestros ingenieros trabajan para solucionarlo.</p>
                        <p><b>Lamentamos las molestias que esto te ocasiona, por favor ingresa nuevamente en 3 minutos.</b><p>");
            break;
        }

        $de = "soporte@teracom.mx";
        $as = "Error en ".$_SERVER['SERVER_NAME']." MySQL" ;
        $he  = "MIME-Version: 1.0";
        $he .= "Content-type: text/html; charset=utf-8";
        $he .= "From: 'SOPORTE' <soporte@teracom.mx>";
        $cuerpo = "<p>ERROR. ".$error."</p>";
        $cuerpo .= "<p>Error n&uacute;mero: ".$noError."</p>";
        $cuerpo .= "<p>Error enviado por: ".$archivo."</p>";
        $cuerpo .= "<p>Linea: ".$linea."</p>";
        $cuerpo .= "<p>Clase: ".$clase."</p>";
        $cuerpo .= "<p>Funcion: ".$funcion."</p>";
        $cuerpo .= "<p>Metodo: ".$metodo."</p>";
        $cuerpo .= "<p>SQL: ".$sql."</p>";
        $cuerpo .= "<p>Error generado en: ".$script."</p>";
        //mail($de,$as,$cuerpo,$he);
        echo $cuerpo;
        exit();
    }

    static function error_sesion($mensaje)
    {
    	if(!empty($mensaje))
    	{
    		include("die.php");
    	}
    }
}

?>