<?php
require_once 'Config.php';

class Conexion
{
    private $id = null;
    function __construct()
	{
          $this->id = pg_connect("host=".HOST." port=".PORT." dbname=".DB_NAME." user=".USER." password=".PASS);
          if (!$this->id) die("Ocurrio un error al intentar la conexion");
	}

	function __destruct()
	{
		if($this->id)
		{
                    echo pg_close($this->id);
		}
	}

        function getIdConexion()
        {
            return $this->id;
        }

}


?>
