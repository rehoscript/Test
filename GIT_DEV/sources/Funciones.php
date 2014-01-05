<?php

include("Utilidades.php");
require_once 'Query.php';


function __($var) {
    $dato = htmlentities($var, ENT_QUOTES, 'UTF-8');
    $dato = stripslashes($dato);
    return trim($dato);
}

/**
 * Verifica si una cadena corresponde a la expresion regular de un correo
 * @param type $email cadena de texto donde esta el correo electronico
 * @return boolean si es correo retorna verdadero
 */
function esEmail($email = "") {
    $car = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($email, '@') !== false && strpos($email, '.') !== false) {
        if (preg_match($car, $email)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * Elimina caracteres no permitidos en los correos electronicos
 * @param type $email cadena de texto donde esta el correo electronico
 * @return type el correo electronico limpio
 */
function limpiaEmail($email) {
    $limpio = preg_replace('/[^a-z0-9+_.@-]/i', '', $email);
    return strtolower($limpio);
}

function codificaMail($email = "") {
    $mailCodificado = "";
    for ($i = 0; $i < strlen($email); $i++) {
        if (rand(0, 1) == 0) {
            $mailCodificado .= "&#" . (ord($email[$i])) . ";";
        } else {
            $mailCodificado .= "&#X" . dechex(ord($email[$i])) . ";";
        }
    }
    return $mailCodificado;
}

/**
 * Funcion para guardar un archivo y retornar la ruta donde se guardo este archivo
 * @param type $carpeta
 * @param type $titulo
 * @return string
 */
function guardaArchivo($carpeta, $titulo) {
    include_once ("Documento.inc");
    $archivoZIP = new Documento();
    $archivoZIP->archivo = $_FILES["zipFile"]["tmp_name"];
    $archivoZIP->error = $_FILES["zipFile"]["errono"];
    $archivoZIP->nombre = $_FILES["zipFile"]["name"];
//echo $img->nombre;
    $archivoZIP->tamano = $_FILES["zipFile"]["size"];
    $archivoZIP->tipo = $_FILES["zipFile"]["type"];
    $archivoZIP->titulo = $titulo;
    $archivoZIP->destino = $carpeta;

    if ($archivoZIP->verificaError()) {
        if ($archivoZIP->verificarExtension()) {
//echo "\nextension correcta";
        }
        if ($archivoZIP->cambiarNombre()) {
//echo "\nNombre cambiado";
        }
        if ($archivoZIP->copia()) {
//echo "  Archivo subido";
        }
    }

    $ruta = UNIDADES_PATH . "/" . $img->nombre;
    return $ruta;
}

/**
 * Limpia texto eliminando acentos y caracteres especiales
 * @param type $String
 * @return type
 */
Function limpiarTexto($String) {

    $String = ereg_replace("[äáàâãª]", "a", $String);
    $String = ereg_replace("[ÁÀÂÃÄ]", "A", $String);
    $String = ereg_replace("[ÍÌÎÏ]", "I", $String);
    $String = ereg_replace("[íìîï]", "i", $String);
    $String = ereg_replace("[éèêë]", "e", $String);
    $String = ereg_replace("[ÉÈÊË]", "E", $String);
    $String = ereg_replace("[óòôõöº]", "o", $String);
    $String = ereg_replace("[ÓÒÔÕÖ]", "O", $String);
    $String = ereg_replace("[úùûü]", "u", $String);
    $String = ereg_replace("[ÚÙÛÜ]", "U", $String);
//$String = ereg_replace("[^´`¨~]", "", $String);
    $String = str_replace("ç", "c", $String);
    $String = str_replace("Ç", "C", $String);
    $String = str_replace("ñ", "n", $String);
    $String = str_replace("Ñ", "N", $String);
    $String = str_replace("Ý", "Y", $String);
    $String = str_replace("ý", "y", $String);
    $String = str_replace("&aacute;", "a", $String);
    $String = str_replace("&eacute;", "e", $String);
    $String = str_replace("&iacute;", "i", $String);
    $String = str_replace("&oacute;", "o", $String);
    $String = str_replace("&uacute;", "u", $String);
    $String = str_replace("&AACUTE;", "A", $String);
    $String = str_replace("&EACUTE;", "E", $String);
    $String = str_replace("&IACUTE;", "I", $String);
    $String = str_replace("&OACUTE;", "O", $String);
    $String = str_replace("&UACUTE;", "U", $String);

    return $String;
}

define('PASSWORD_BCRYPT', 1);
define('PASSWORD_DEFAULT', PASSWORD_BCRYPT);

function verificaBcrypt($password, $hash) {
    $ret = crypt($password, $hash);
    if (!is_string($ret) || strlen($ret) != strlen($hash) || strlen($ret) <= 13) {
        return false;
    }

    $status = 0;
    for ($i = 0; $i < strlen($ret); $i++) {
        $status |= (ord($ret[$i]) ^ ord($hash[$i]));
    }

    return $status === 0;
}

function passBCrypt($password, $algo = PASSWORD_BCRYPT, array $options = array()) {

    switch ($algo) {
        case PASSWORD_BCRYPT:
// Note that this is a C constant, but not exposed to PHP, so we don't define it here.
            $cost = 10;
            if (isset($options['cost'])) {
                $cost = $options['cost'];
                if ($cost < 4 || $cost > 31) {
                    trigger_error(sprintf("password_hash(): Invalid bcrypt cost parameter specified: %d", $cost), E_USER_WARNING);
                    return null;
                }
            }
            $required_salt_len = 22;
            $hash_format = sprintf("$2y$%02d$", $cost);
            break;
        default:
            trigger_error(sprintf("password_hash(): Unknown password hashing algorithm: %s", $algo), E_USER_WARNING);
            return null;
    }
    if (isset($options['salt'])) {
        switch (gettype($options['salt'])) {
            case 'NULL':
            case 'boolean':
            case 'integer':
            case 'double':
            case 'string':
                $salt = (string) $options['salt'];
                break;
            case 'object':
                if (method_exists($options['salt'], '__tostring')) {
                    $salt = (string) $options['salt'];
                    break;
                }
            case 'array':
            case 'resource':
            default:
                trigger_error('password_hash(): Non-string salt parameter supplied', E_USER_WARNING);
                return null;
        }
        if (strlen($salt) < $required_salt_len) {
            trigger_error(sprintf("password_hash(): Provided salt is too short: %d expecting %d", strlen($salt), $required_salt_len), E_USER_WARNING);
            return null;
        } elseif (0 == preg_match('#^[a-zA-Z0-9./]+$#D', $salt)) {
            $salt = str_replace('+', '.', base64_encode($salt));
        }
    } else {
        $buffer = '';
        $raw_length = (int) ($required_salt_len * 3 / 4 + 1);
        $buffer_valid = false;
        if (function_exists('mcrypt_create_iv')) {
            $buffer = mcrypt_create_iv($raw_length, MCRYPT_DEV_URANDOM);
            if ($buffer) {
                $buffer_valid = true;
            }
        }
        if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
            $buffer = openssl_random_pseudo_bytes($raw_length);
            if ($buffer) {
                $buffer_valid = true;
            }
        }
        if (!$buffer_valid && file_exists('/dev/urandom')) {
            $f = @fopen('/dev/urandom', 'r');
            if ($f) {
                $read = strlen($buffer);
                while ($read < $raw_length) {
                    $buffer .= fread($f, $raw_length - $read);
                    $read = strlen($buffer);
                }
                fclose($f);
                if ($read >= $raw_length) {
                    $buffer_valid = true;
                }
            }
        }
        if (!$buffer_valid || strlen($buffer) < $raw_length) {
            $bl = strlen($buffer);
            for ($i = 0; $i < $raw_length; $i++) {
                if ($i < $bl) {
                    $buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
                } else {
                    $buffer .= chr(mt_rand(0, 255));
                }
            }
        }
        $salt = str_replace('+', '.', base64_encode($buffer));
    }
    $salt = substr($salt, 0, $required_salt_len);

    $hash = $hash_format . $salt;

    $ret = crypt($password, $hash);

    if (!is_string($ret) || strlen($ret) <= 13) {
        return false;
    }

    return $ret;
}

function nCrypt($string) {
    $arrayLetras = arrayLetras();
    $arrayNCrypt = arrayNCrypt();
    $arrTexto = str_split($string, 1);
    $strCrypted = "";
    foreach ($arrTexto as $a) {
        if (in_array($a, $arrayLetras)) {
            $index = array_search($a, $arrayLetras);
            $strCrypted = $strCrypted . $arrayNCrypt[$index];
        } else {
            $strCrypted = $strCrypted . "$!" . $a . "}/";
        }
    }
    return $strCrypted;
}

function nDCrypt($string) {
    $arrayLetras = arrayLetras();
    $arrayNCrypt = arrayNCrypt();
    $arrTexto = str_split($string, 5);
    $strDeCrypted = "";
    foreach ($arrTexto as $a) {
        if (in_array($a, $arrayNCrypt)) {
            $index = array_search($a, $arrayNCrypt);
            $strDeCrypted = $strDeCrypted . $arrayLetras[$index];
        } else {
            $strDeCrypted = $strDeCrypted . substr($a, 2, 1);
        }
    }
    return $strDeCrypted;
}

function arrayLetras() {
    return array(
        "a", "b", "c", "d", //1
        "e", "f", "g", "h", //2
        "i", "j", "k", "l", //3
        "m", "n", "ñ", //4
        "o", "p", "q", "r", //5
        "s", "t", "u", "v", //6
        "w", "x", "y", "z", //7
        "A", "B", "C", "D", //8
        "E", "F", "G", "H", //9
        "I", "J", "K", "L", //10
        "M", "N", "Ñ", //11
        "O", "P", "Q", "R", //12
        "S", "T", "U", "V", //13
        "W", "X", "Y", "Z", //14
        "1", "2", "3", "4", //15
        "5", "6", "7", "8", //16
        "9", "0"//17
    );
}

function arrayNCrypt() {
    return arraY(
        "86y9a", ",wx7/", "@bEsV", "5E-h[", //1
        "uxuH=", "Dak8a", "F45c4", "sR*VY", //2
        "dUKp9", "ysmi,", "+vF}N", "Sm@FW", //3
        "%OvRt", "9-59U", "=r4N%", //4
        "6JeU]", "#:.A4", "kxr)s", "556fD", //5
        "xPM_6", "QSEAm", "_Es6p", "zHFL#", //6
        "X-1HL", "xak#G", "JS@5u", "=*[F}", //7
        "d[Q]8", "@UU?y", "Hxz!U", "Q?.-u", //8
        "+G.4s", "wB58)", "XcD)A", "aS1RX", //9
        "7tAzc", "61:y@", "dbG[h", "X%dUJ", //10
        "JfKuy", "q([sy", "-?_4N", //11
        "Wp7L(", "}dbd0", "C7}CV", "Qf[eP", //12
        "MrPZi", "y/2nw", "/x-7c", "@pC2d", //13
        "E<iCy", "9xd]|", "tmn:m", "K450v", //14
        "9PS%i", "7]{W=", "o6#{4", "@+@y1", //15
        "hsvZy", "n6ib2", "Zm*}V", "o2esF", //16
        "5Du3=", "w,AXt"//17
    );
}

function descomprimeZIP($id_unidad, $nombreArchivo) {
    $zip = new ZipArchive();
    echo UNIDADES_PATH . "/" . $nombreArchivo;
    if ($zip->open(UNIDADES_PATH . "/" . $nombreArchivo) === TRUE) {
        $zip->extractTo(UNIDADES_PATH . "/" . $id_unidad);
        $zip->close();
        echo 'ok';
    } else {
        echo 'failed';
    }
//Elimina el .zip
    unlink(UNIDADES_PATH . "/" . $nombreArchivo);
}

function unidadEnAlgunaSerie($idUnidad) {

    $query = new Query("SG");
    $query->sql = "select id_serie_aer from serie_aer where id_unidad = $idUnidad";
    $series = $query->select("obj");
    if ($query->numRegistros() > 0) {
        return true;
    } else {
        return false;
    }
}

function cursosMoodleParaSerie($idCursoSG) {
//Crea objeto para realizar consultas al sistema de gestion
    $query = new Query("SG");
//Query a Moodle
    $query->sql = "SELECT * from unidades where id_curso=$idCursoSG and status = 1 and url_unidad is not null";
    $resultado = $query->select("obj");

    if ($resultado) {
        foreach ($resultado as $topico) {
            if (!unidadEnAlgunaSerie($topico->id_unidad))
                $boton = '<a class="btn btn-info" data-toggle="modal" href="#verModalLinkeo" onclick="llenaModalLinkeo(\'' . $topico->id_unidad . '\');">Agregar informaci&oacute;n de series';
            else
                $boton = '<a class="btn btn-success" data-toggle="modal" href="#verModalLinkeo" onclick="llenaModalLinkeoEditar(\'' . $topico->id_unidad . '\');">Editar informaci&oacute;n de series';
            echo <<<HTML
            <div class="well">
                <h5>$topico->nombre_unidad </h5> $boton </a> 
            </div>
HTML;
        }
    } else {
        echo "<h3 class='text-warning'>No hay t&oacute;picos en este curso.</h3>";
    }
}

function comboHabilidades() {

    $query = new Query("SG");

    $query->sql = "SELECT * from habilidades where status = 1";
    $habilidades = $query->select("obj");
    $var = "";
    if ($habilidades) {
        foreach ($habilidades as $hab) {
//            echo<<<hab
//        <option value = "$hab->id_habilidad">$hab->nombre_habilidad</option>
//hab;  

            $ns = ($hab->nombre_habilidad);
            $var = $var . "<option value = '$hab->id_habilidad'>$ns</option>";
        }
    }
    return $var;
}

function comboHabilidadesConSelected($idSelected) {

    $query = new Query("SG");

    $query->sql = "SELECT * from habilidades where status = 1";
    $habilidades = $query->select("obj");
    $var = "";
    if ($habilidades) {
        foreach ($habilidades as $hab) {
//            echo<<<hab
//        <option value = "$hab->id_habilidad">$hab->nombre_habilidad</option>
//hab;
            $ns = html_entity_decode($hab->nombre_habilidad);
            if ($idSelected == $hab->id_habilidad) {
                $var = $var . "<option value = '$hab->id_habilidad' selected='selected'>$ns</option>";
            } else {
                $var = $var . "<option value = '$hab->id_habilidad'>$ns</option>";
            }
        }
    }
    return $var;
}

function comboTipoElemento() {

    $query = new Query("SG");

    $query->sql = "SELECT * from tipo_elemento where status = 1";
    $tiposE = $query->select("obj");
    $var = "";
    if ($tiposE) {
        foreach ($tiposE as $te) {
            $var = $var . "<option value = '$te->id_tipo_elemento'>$te->nombre_tipo</option>";
//            echo<<<hab
//        <option value = "$te->id_tipo_elemento">$te->nombre_tipo</option>
//hab;
        }
    }else{
        echo <<<html
            <option value="">No hay tipos de elementos</option>
html;
    }
    return $var;
}

/**
 * Genera un combo box con los padres registrados en la base de datos
 */
function comboPadres() {
    $query = new Query("SG");

    $query->sql = "SELECT  p.id_padre, dp.nombre_pila, dp.primer_apellido, dp.segundo_apellido FROM padres p, datos_personales dp where p.id_datos_personales=dp.id_datos_personales and p.status = 1";
    $padres = $query->select("obj");

    echo <<<combo
        <option value="">Seleccione un Padre</option>
combo;
    if ($padres) {
        
        foreach ($padres as $padre) {
            echo <<<HTML
                <option value="$padre->id_padre">$padre->nombre_pila $padre->primer_apellido $padre->segundo_apellido</option>
HTML;
        }
    }
}

/**
 * Function que genera opciones de un combo de los
 * profesores de aula en la base de datos
 */
function comboProfesoresAula() {
    $query = new Query("SG");

    $query->sql = "SELECT  p.id_profesor_aula, dp.nombre_pila, dp.primer_apellido, dp.segundo_apellido FROM profesores_aula p, datos_personales dp where p.id_datos_personales=dp.id_datos_personales and p.status = 1";
    $profesores = $query->select("obj");

    echo <<<combo
        <option value="">Seleccione un Profesor de Aula</option>
combo;
    if ($profesores) {
        foreach ($profesores as $profesor) {
            echo <<<HTML
                <option value="$profesor->id_profesor_aula">$profesor->nombre_pila $profesor->primer_apellido $profesor->segundo_apellido</option>
HTML;
        }
    }
}

/**
 * Funcion que genera un combo con las empresas registradas
 * en la base de datos
 */
function comboEmpresas() {
    $query = new Query("SG");

    $query->sql = "SELECT  id_empresa, nombre_empresa FROM empresa where status = 1";
    $empresas = $query->select("obj");

    if ($empresas) {
        foreach ($empresas as $empresa) {
            echo <<<HTML
                <option value="$empresa->id_empresa">$empresa->nombre_empresa</option>
HTML;
        }
    }else{
        echo <<<html
            <option value=''>No hay empresas disponibles</option>
html;
    }
}

/**
 * Funcion que recibe un post y de todos los atributos genera un arreglo para los campos
 * y para los valores
 * @param type $_POST El post del formulario
 * @param type $delimitador delimitador para cuando se trabaja con varias tablas
 * @param type $tablas las tablas a las cuales se desea dividir los campos y valores, son las tablas dividido por comas
 * @return array ("campos" => $campos, "valores" => $valores), dependiendo de si hay varias tablas $campos y $valores seran arreglos
 */
function destripaPost($POST, $delimitador = NULL, $tablas = NULL) {

    if (isset($delimitador) && isset($tablas)) {
        $campos = array();
        $valores = array();
    } else {
        $campos = "";
        $valores = "";
    }

    if (isset($tablas)) {
        $tablas = explode(",", str_replace(" ", "", $tablas));
    }

    foreach ($POST as $campo => $valor) {
        if (isset($delimitador) && isset($tablas)) {
            $referencia = explode($delimitador, $campo);
            $refTabla = $referencia[0];
            $col = $referencia[1];

            if ($col != "" && $valor != "") {
                $valor = __($valor);
                //Guarda los datos
                foreach ($tablas as $t) {
                    if ($refTabla == $t) {
                        $campos["$t"] = $campos["$t"] . ", " . $col;
                        $valores["$t"] = $valores["$t"] . ", " . "'$valor'";
                    }
                }
            }
        } else {
            $campos = $campos . ", " . $campo;
            $valores = $valores . ", " . "'$valor'";
        }
    }

//LImpiar primeras comas
    if (isset($delimitador) && isset($tablas)) {
//Limpia la primera coma
        foreach ($tablas as $t) {
            $campos["$t"] = substr($campos["$t"], 1);
            $valores["$t"] = substr($valores["$t"], 1);
        }
    } else {
        $campos = substr($campos, 1);
        $valores = substr($valores, 1);
    }

    return array("campos" => $campos, "valores" => $valores);
}

function destripaPostEdicion($POST, $delimitador = NULL, $tablas = NULL) {
    $sets = array();

    if (isset($tablas)) {
        $tablas = explode(",", str_replace(" ", "", $tablas));
    }

    foreach ($POST as $campo => $valor) {
        if (isset($delimitador) && isset($tablas)) {
            $referencia = explode($delimitador, $campo);
            $refTabla = $referencia[0];
            $col = $referencia[1];

            if ($col != "" && $valor != "") {
                $valor = __($valor);
//Guarda los datos
                foreach ($tablas as $t) {
                    if ($refTabla == $t) {
                        if($valor=="null"){
                            $sets["$t"] = $sets["$t"] . ", $col = $valor";
                        }else{
                            $sets["$t"] = $sets["$t"] . ", $col = '$valor'";
                        }
                        
                    }
                }
            }
        } else {
            $sets = $sets . ", $col='$valor'";
        }
    }

//LImpiar primeras comas
    if (isset($delimitador) && isset($tablas)) {
//Limpia la primera coma
        foreach ($tablas as $t) {
            $sets["$t"] = substr($sets["$t"], 1);
        }
    } else {
        $sets = substr($sets, 1);
    }

    return $sets;
}

function comboRolesTutores() {
    $query = new Query("SG");

    $query->sql = "SELECT  id_rol_tutor, nombre FROM rol_tutor where status = 1";
    $roles = $query->select("obj");

    if ($roles) {
        foreach ($roles as $rol) {
            echo <<<HTML
                <option value="$rol->id_rol_tutor">$rol->nombre</option>
HTML;
        }
    }else{
        echo <<<html
            <option value="">No hay roles</option>
html;
    }
}

function guardaStorage($FILE, $carpeta, $destino, $actualiza = NULL) {

//    echo "<br>Archivo:";
//    var_dump($FILE);
//    echo "<br>id_unidad:$id_unidad";
//set POST variables
    $base = BASE_STORAGE;
    $url = $base . "gdaStorage.php";

    $servArchivos = fopen($url, "r");

    if ($servArchivos !== false) {
//        imprimeConsola("Enviando archivos a: $url");
//    echo " url:$url";
        try {
//open connection        
            $ch = curl_init();

//set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, "loquesea");
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);

            $post = array(
                "archivo" => "@" . $FILE,
                "carpeta" => $carpeta,
                "destino" => $destino,
                "actualiza" => $actualiza
            );
//            imprimeConsola("POST:");
//            var_dump($post);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
//            echo "<br>RESPONSE:<br>";
//            var_dump($response);
//            echo "<br>$response";
            return $base . $response;
        } catch (Exception $e) {
            imprimeError($e->getMessage());
        }
    } else {
        imprimeError("No se puede abrir el script de guardado");
        return false;
    }
}

/**
 * Redirect with POST data.
 *
 * @param string $url URL.
 * @param array $post_data POST data. Example: array('foo' => 'var', 'id' => 123)
 * @param array $headers Optional. Extra headers to send.
 */
function redirect_post($url, array $data, array $headers = null) {
    $params = array(
        'http' => array(
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    if (!is_null($headers)) {
        $params['http']['header'] = '';
        foreach ($headers as $k => $v) {
            $params['http']['header'] .= "$k: $v\n";
        }
    }
    $ctx = stream_context_create($params);
    $fp = @fopen($url, 'rb', false, $ctx);
    if ($fp) {
        echo @stream_get_contents($fp);
        die();
    } else {
        // Error
        throw new Exception("Error loading '$url', $php_errormsg");
    }
}

//Inicia control de cambios #3
function verificaCookieTipo() {
    if (isset($_COOKIE["smTipo"])) {
        $tipo = -1;
        switch ($_COOKIE["smTipo"]) {
            case "alumno":
                $tipo = 0;
                break;
            case "Junior":
                $tipo = 1;
                break;
            case "Senior":
                $tipo = 1;
                break;
            case "Coordinador":
                $tipo = 1;
                break;
            case "profesorAula":
                $tipo = 2;
                break;
            case "padre":
                $tipo = 3;
                break;
            case "gestorContenidos":
                $tipo = 4;
                break;
            case "administrador":
                $tipo = 5;
                break;
        }
        llenaSesionAuth($_COOKIE["smIdDatosPersonales"]);
        llenaArregloSesion($tipo, $_COOKIE["smNombre"], $_COOKIE["smIdDatosPersonales"], $_COOKIE["smIdPorTabla"], date("H:i:s"));
//        header("Location:../../admin/index.php");
        return true;
    } else {
//        header("Location:../../index.php");
        return false;
    }
}

function llenaSesionAuth($idDatosPersonales) {
    require_once 'Query.php';
    $sql = new Query("SG");
    $sql->sql = "
                select *
                from datos_personales
                where id_datos_personales = " . $idDatosPersonales . "
            ";
    $listaUsuarios = $sql->select("obj");
    if (!empty($listaUsuarios)) {
        foreach ($listaUsuarios as $us){
            $_SESSION['userMail']=$us->nombre_usuario;
            $_SESSION['pass']=  nDCrypt($us->contrasena);
        }
    }
}

//Finaliza control de cambios #3
function existeSession() {
    if (esAlumno() || esJr() || esSenior() ||
            esCoordinador() || esProfesorAula() || esPadre() || esGestorContenido() || esAdministrador())
        return true;
    else
        return false;
}


function enviarMailComentario($nombre,$correo,$comentario)
{  
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=utf-8\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
  $headers .= "From: MetaSpace";
            
            $mensaje = <<<correo
    <html>
    <head>
    <title>Bienvenido a MetaSpace</title>
    </head>
    <body>   
    <h1>$nombre</h1>
    <h2>$correo<br/>Comentario:</h2>
    <p>"$comentario"</p>   
    <b>MetaSpace.</b>
    </body>
    </html>
correo;
            $titulo   = 'Comentario'; 
            
            
            $res=mail(obtenerValorCorreoContacto(), $titulo, $mensaje, $headers);
            if($res)
                return true;
            else
                return false;
    
}

function obtenerValorCorreoContacto()
{
    $arrayConfig = parse_ini_file("Variables.ini");
    return $arrayConfig['correoContacto'];
}
function guardar($POST)
{
    $array = array($POST);
    
    INI::write("Variables.ini",$array);
}
function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
    
    
    ////Ejemplo de llamado $yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
} 

?>