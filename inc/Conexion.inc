<?php
//   Date             Modified by         Change(s)
//   2013-09-24         HMP                 1.0
require_once 'Config.php';
require_once 'Error.inc';
class Conexion
{
    private $id = null;
    
    function __construct()
    {
          $URL="host=".HOST." port=".PORT." dbname=".DB_NAME." user=".USER." password=".PASS;
          $this->id = pg_connect($URL, PGSQL_CONNECT_FORCE_NEW)  ;
          if (!$this->id) 
              die (pg_errormessage());

    }
     #esto puede cambiar despues
     function __destruct()
     {
		if($this->id)
		{
                    return pg_close($this->id);
		}
     }

     function getIdConexion()
     {
            return $this->id;
     }

}


?>
