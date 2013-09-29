<?php
if (!file_exists("Conexion.inc"))
	die("<p>El archivo <code><b>Conexion.inc</b></code> no existe en el directorio ra&iacute;z.<br/></p>");

require_once 'Conexion.inc';

class Query
{
	public  $sql;
        private  $conexion;
        private  $idConexion;
        private  $idQuery;
        private $arregloObj;
	private $arregloArr;
        
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
            if(!empty($this->sql))
	    {
                unset($this->idQuery,$this->arregloObj,$this->arregloArr);
                $this->idQuery = pg_query($this->idConexion, $this->sql);//falta el Error
                
                if($this->numRegistros()>0)
                {
                    if(strcmp($tipo,"obj")==0)
                    {
                        $this->arregloObj = array();
                        while($row = pg_fetch_object($this->idQuery))
                        {
                            $this->arregloObj[] = $row;
                        }
                        return $this->arregloObj;
                    }
                    else if(strcmp($tipo,"arr")==0)
                    {
                        $this->arregloArr = array();
                        $this->arregloArr = pg_fetch_array($this->idQuery);
                        return $this->arregloArr;
                    }
                    else
                    {
                        die("<h3>ERROR: No me has dicho como quieres los registros?.</h3>");
                    }
                }
                else
                {
                    return NULL;
                }
	    }
	    else
	    {
                die("<h3>ERROR: No has especificado un query &quot;SELECT&quot; v&oacute;lido.</h3>");
	    }
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
            return ($this->idQuery)? pg_num_rows($this->idQuery):0;
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
