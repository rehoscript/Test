<?php

class Conexion
{
	private $con=null;
    function __construct()
	{
          $this->con = pg_connect("host=".HOST." port=".PORT." dbname=".DB_NAME." user=".USER." password=".PASS);
          if (!$this->con) die("Ocurrio un error al intentar la conexion");
	}

	function __destruct()
	{
		
	}


}
?>
