<?php
//   Date             Modified by         Change(s)
//   2013-09-24         HMP                 1.0
if (!file_exists("Conexion.inc"))
	die("<p>El archivo <code><b>Conexion.inc</b></code> no existe en el directorio ra&iacute;z.<br/></p>");
if (!file_exists("Error.inc"))
	die("<p>El archivo <code><b>Error.inc</b></code> no existe en el directorio ra&iacute;z.<br/></p>");
require_once 'Conexion.inc';
require_once 'Error.inc';

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

	function select($tipo = "obj")
	{
            if(!empty($this->sql))
	    {
                unset($this->idQuery,$this->arregloObj,$this->arregloArr);
                $this->idQuery = pg_query($this->idConexion, $this->sql)
                or die(Error::error_pgsql(pg_errormessage(),__FILE__,__LINE__,__CLASS__,__FUNCTION__,__METHOD__,$_SERVER['PHP_SELF'],$this->sql));
                
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
                        //$this->arregloArr = pg_fetch_array($this->idQuery,5, PGSQL_BOTH);
                        while($row = pg_fetch_array($this->idQuery,NULL, PGSQL_BOTH))
                        {
                            $this->arregloArr[] = $row;
                        }
                        
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
                if(!empty($sql))
		{
			unset($this->sql,$this->idQuery);
			$this->idQuery = pg_query($this->idConexion,$sql)
                        or die(Error::error_pgsql(pg_errormessage(),__FILE__,__LINE__,__CLASS__,__FUNCTION__,__METHOD__,$_SERVER['PHP_SELF'],$this->sql));	
			return TRUE;
		}
		else
		{
			exit("<p>ERROR: No has especificado un query &quot;UPDATE&quot; v&aacute;lido.</p>");
		}
        }

	function insert($tabla = NULL, $campos = NULL, $values = NULL)
	{
                if(!empty($tabla) || !empty($campos) || !empty($values))
		{
			unset($this->sql);
			$this->sql = "INSERT INTO $tabla ($campos) VALUES ($values) ";
                        $this->idQuery = pg_query($this->idConexion, $this->sql)
                        or die(Error::error_pgsql(pg_errormessage(),__FILE__,__LINE__,__CLASS__,__FUNCTION__,__METHOD__,$_SERVER['PHP_SELF'],$this->sql));
		}
		else
		{
			exit("<p>ERROR: No has especificado un query &quot;INSERT&quot; v&aacute;lido.</p>");
		}
	}

	function delete($tabla = NULL, $where = NULL)
	{
                if(!empty($tabla) || !empty($where))
		{
			unset($this->sql,$this->idQuery);
                        $this->sql = "DELETE FROM $tabla WHERE $where";
                        $this->idQuery = pg_query($this->idConexion, $this->sql)
                        or die(Error::error_pgsql(pg_errormessage(),__FILE__,__LINE__,__CLASS__,__FUNCTION__,__METHOD__,$_SERVER['PHP_SELF'],$this->sql));
                            
                        //Falta optimizar
                        return TRUE;
		}
		else
		{
			exit("<p>ERROR: No has especificado un query &quot;DELETE&quot; v&aacute;lido.</p>");
		}
	}


	#Devuielve numero de campos obtenidos de un select
	function numCampos()
	{
            return ($this->idQuery)? pg_num_fields($this->idQuery):0;
	}

	#Retorna el numero de tuplas modificadas en INSERT, UPDATE, and DELETE queries. 
	function camposAfectados()
	{
            return ($this->idQuery)?pg_affected_rows($this->idQuery):0;
	}

	#Devuelve el numero de registros obtenidos de un SELECT
	function numRegistros()
	{
            return ($this->idQuery)? pg_num_rows($this->idQuery):0;
	}
        
	function flush()
	{
           if($this->idQuery)
	   {
	       pg_free_result($this->idQuery);
	       return;
	   }
	 
	}
}



?>
