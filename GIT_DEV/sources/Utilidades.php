<?php 

abstract class Utilidades
{
	static function __($var)
	{
		$dato =	htmlentities($var,ENT_QUOTES,'UTF-8');
		$dato = strip_tags($dato);
		$dato = stripslashes($dato);
		return trim(addslashes($dato));
	}

	static function reduceTxt($txt,$cuantos)
	{
		$t = utf8_encode(html_entity_decode($txt)); 
		if($cuantos<strlen($txt))
		{	
			for($i=$cuantos;$i>$cuantos-10;$i--)
			{
				if(@strcmp($t{$i}," ")==0)break;
			}
			return substr($t,0,$i)." ...";
		}
		else
		{
			return $t;
		}
	}

	static function obtenIP()
	{
		if(isset($_SERVER)) {
			if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else if(isSet($_SERVER["HTTP_CLIENT_IP"])) {
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			} else {
				$realip = $_SERVER["REMOTE_ADDR"];
			}
		} else {
			if( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
				$realip = getenv( 'HTTP_X_FORWARDED_FOR' );
			} else if( getenv( 'HTTP_CLIENT_IP' ) ) {
				$realip = getenv( 'HTTP_CLIENT_IP' );
			} else {
				$realip = getenv( 'REMOTE_ADDR' );
			}
		}
		return $realip;
	}

	static function esEmail($email = "")
	{
		$car = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
		if (strpos($email, '@') !== FALSE && strpos($email, '.') !== FALSE)
		{
			if (preg_match($car, $email)) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	static function limpiaEmail($email)
	{
		$limpio = preg_replace('/[^a-z0-9+_.@-]/i', '', $email);
		return strtolower(_($limpio));
	}

	static function obtenFecha($fecha)
	{
		global $mes;
		$txt = explode("-",$fecha);
		return $txt[2]." de ".$mes[(int)$txt[1]]." de ".$txt[0];
	}
        
        static function obtenHoy()
	{
            $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
            return $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
	}
	
	static function dominioDeEmail($email = NULL)
	{
		if(!empty($email))
		{
			$email = strtolower($email);
			return substr(strrchr($email, '@'),1);
		}
		else
		{
			exit("<p>No se ha proporcionado un dominio para procesar.");
		}
	}
	
	static function existeDominioDeEmail($dominio = NULL)
	{
		if(!empty($dominio))
		{
			$existe = FALSE;
			$url = "http://".$dominio;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
			$existe = (curl_errno($ch))?TRUE:FALSE;
			curl_close($ch);
			return $existe;
		}
		else
		{
			exit("<p>NO se ha proporcionado una direccion de email para extraer su extension</p>");
		}
	}
	
	static function generaPwd($longitud = 6)
	{
                return substr(sha1(uniqid(rand())),0,$longitud);
		//return chr(rand(33,48)).substr(sha1(uniqid(rand())),0,$longitud).chr(rand(33,48));
	}
	
	static function encriptaTxt($txt, $x = "\?'#~")
	{
		return sha1($txt.$x);
	}

	static function generaLlave()
	{
		#return substr(sha1(uniqid(rand())),0,16);
		#global $config;
		#echo $config["codificacion"];
	}
	
	static function teracom()
	{
		echo '<a href="http://teracom.mx" target="_blank" title="Dise&ntilde;o paginas web toluca atlacomulco metepec m&eacute;xico">
		<img src="'.ABSPATH.'imagenes/separator.png" alt="Dise&ntilde;o paginas web toluca atlacomulco metepec m&eacute;xico" border="0" width="0" height="0" /></a>';
	}
	
	static function generaUrl($txt)
	{
		$ca = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;","&ntilde;", "&Ntilde;");
		$sa = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U","n", "N");
		$txt = str_replace($ca,$sa,trim($txt));
		$txt = str_replace(" ","-",$txt);
		return strtolower(preg_replace("/[^a-z0-9-]/i", "", $txt));
	}
	
	static function HTML($txt)
	{
		return utf8_encode(html_entity_decode($txt));
	}
	
	static function quitarHTML($etiqueta)
	{
		return strip_tags(trim($etiqueta));
	}
	
	/*
	* @param $valor - numero flotante
	* @param $moneta - tipo de moneda [pesoMX, dolar, libra, yen, franco, lira, peseta, euro]
	*/
	static function formatoPrecio($valor,$moneda)
	{
		$precio = "";
  		switch($moneda)
  		{
  			case "pesoMX": $precio = "&#36; ";	break;
			case "dolar": $precio = "USD &#36; "; break;
			case "libra": $precio = "&#163; "; break;
			case "yen": $precio = "&#165; "; break;
			case "franco": $precio = "&#8355; "; break;
			case "lira": $precio = "&#8356; "; break;
			case "peseta": $precio = "&#8359; "; break;
			case "euro": $precio = "&#128; "; break;
			default: exit("Moneda no encontrada"); break;	
  		}	
		return $precio.number_format($valor,2,'.',',');
	}

	static function codificarMail($email, $tipo = "utf")
	{
		switch($tipo)
		{
			default:
			case "utf":
				$mailCodificado = "";
	    		for ($i=0; $i < strlen($email); $i++)
				{
	        		if(rand(0,1) == 0)
					{
						//ord($var) - Devuelve el valor ASCII de un entero. 
	            		$mailCodificado .= "&#" . (ord($email[$i])) . ";";
	        		}
					else
					{
						//dechex($var) - Devuelve la cadena hexadecimal de un n?mero
	            		$mailCodificado .= "&#X" . dechex(ord($email[$i])) . ";";
	        		}
	    		}
				return $mailCodificado;
			break;
			case "@":
				$original = array('@','.');
				$sust = array("[arroba]","[punto]");
				return str_replace($original,$sust,$email);
			break;
			case "js":
				return "<script language='javascript' type='text/javascript' >\n
			   				document.write(\"$email\");\n
		       			< /script>";
			break;
		}
	}
	
	
	/*
	 * En los otros dos falta checar si existe el directorio LOGS/
	 */
	static function logIO($io,$msg)
	{
		if(LOG_ERRORES)
		{
			$fp = fopen("log.log","a+");
			$date = date("Y-m-d H:i:s ");
			$io = ($io == 'I') ? " Input: " : " Output: ";
			fwrite($fp, "\n".$date.$io.$msg);
			fclose($fp);
			return TRUE;
		}
	}

	static function ocultaTxt($txt, $car = '*')
	{
		return str_repeat($car, strlen($txt));
	}

	static function letraAleatoria()
	{
   		return chr(rand(97, 122));
	}
	
	static function caracterAleatorio()
	{
   		return chr(rand(33, 48));
	}
	
	static function token()
	{
		$time = microtime();
   		$time = explode(" ", $time);
   		$microtime = $time[1] . substr($time[0], 2);
   		return $microtime.self::letraAleatoria().self::letraAleatoria().self::letraAleatoria().rand(1000, 100000).self::letraAleatoria().self::letraAleatoria().rand(1000, 900000);
	}
	
	/*
	 * @param $filesize en kilobytes
	 */
	static function tamanoArchivo($filesize)
	{
    	if(is_numeric($filesize))
    	{
    		$decr = 1024; $step = 0;
    		$prefix = array('Kbs','Mb','Gb','Tb','Pb');
       
    		while(($filesize / $decr) > 0.9)
    		{
        		$filesize = $filesize / $decr;
        		$step++;
    		}
    		return round($filesize,2).' '.$prefix[$step];
    	}
    	else
    	{
	    	return 0;
    	}
	}

	static function existeDirectorio($directorio)
	{
		if(is_dir(ABSPATH.$directorio) && is_readable(ABSPATH.$directorio))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	static function creaDirectorio($directorio)
	{
		if(mkdir(ABSPATH.$directorio,0777,TRUE))
		{
			echo (RESULTTRACE)?"<p>El directorio ".ABSPATH.$directorio.DS.", ha sido creado correctamente</p>":"";
			return TRUE;
		}
		else 
		{
			exit("<p>El directorio &quot;$directorio&quot; no puede ser creado, intente nuevamente.</p>");
		}
	}
	
	#falta trabnajarla
	/*function eliminaArchivo($archivo)
	{
		return unlink($file);
	}
		
		function eliminarcarpeta($file,$prof=""){
 	 return rmdir($file);
}
	*
	**/
	
}
?>