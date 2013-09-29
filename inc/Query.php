<?php
if (!file_exists("Conexion.inc"))
	die("<p>El archivo <code><b>Conexion.inc</b></code> no existe en el directorio ra&iacute;z.<br/></p>");

require_once 'Conexion.inc';

class Query
{
	private  $sql;
        private  $conexion;
        private  $idConexion;
        private $idQuery;
	function __construct()
	{
            $this->conexion = new Conexion();
            $this->idConexion = $this->conexion->getIdConexion();
                    
	}

	function __destruct()
	{
	
	}

	function select($tipo = "obj")
	{
	
	}

	function update($sql = NULL)
	{
	
        }

	function insert($tabla = NULL, $campos = NULL, $values = NULL)
	{
                if(!empty($tabla) || !empty($campos) || !empty($values))
		{
			unset($this->sql);
			$this->sql = "INSERT INTO $tabla ($campos) VALUES ($values) ";
                        $this->idQuery = pg_query($this->idConexion, $this->sql)
                        or die(pg_errormessage());
		}
		else
		{
			exit("<p>ERROR: No has especificado un query &quot;INSERT&quot; v&aacute;lido.</p>");
		}
	}

	function delete($tabla = NULL, $where = NULL)
	{
	
	}

	function cuentaCampos($campo = '*', $tabla = NULL, $where = '1')
	{
            
	}

	#Devuielve numero de campos obtenidos de un select
	function numCampos()
	{

	}

	#Falta numero de registros aafetctados
	function camposAfectados()
	{

	}

	#Devuelve el numero de registros obtenidos de un SELECT
	function numRegistros()
	{

	}


	function optimiza($tabla = NULL)
	{

	}

	function query($sql = NULL)
	{
	
	}

	function flush()
	{
	 
	}
}



?>
