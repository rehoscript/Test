<?php

include("Utilidades.php");
require 'Query.php';

function generarListadoCommits($correo)
{
    $sql = new Query('MOD');
    $sql->sql = "SELECT * FROM commit WHERE auto='".$correo."'";
    //$sql->sql = "SELECT id from commit";
    $resultado = $sql->select('obj');
    
    if($resultado)
    {
        $texto ="";
        foreach ($resultado as $commit) 
        {
            $texto .= '<div class="list-group">
                  
                  <a href="#" class="list-group-item">
                    
                    <i class="fa fa-globe"></i> '.$commit->nombre.'
                  </a>
                   <a href="#" class="list-group-item">
                    
                    <i class="fa fa-calendar"></i> '.$commit->fecha.'
                  </a>
                  <a href="#" class="list-group-item">
                    <i class="fa fa-check"></i>Archivos:
                    <br/>
                    <ul>
                 ';
//            
            $resultado2 = exts($commit->id);
            if($resultado2)
            {
                foreach ($resultado2 as $archivo) 
                {
                    $texto .= '<li>'.$archivo->archivo.'</li>';
                }
            }
            
            $texto.="  </ul></a>
                </div>";
        }
        
        return $texto;
    }
    
}


function exts($id)
{
    $sql5 = new Query('MOD');
            $sql5->sql = "SELECT * FROM archivos  WHERE id_commit = ".$id;
           return  $resultado2 = $sql5->select();
}

function insertCommit($date, $mail, $name)
{
     $sql = new Query('MOD');
     $sql->insert("commit",
             "fecha,auto,nombre",
             "'".$date."','".$mail."','".$name."'");
        
      return $ultimoID = $sql->ultimoID("commit");
}

function insertFile($file, $ultimoID)
{
     $sql3 = new Query('MOD');
     $sql3->insert("archivos",
             "archivo,id_commit",
             "'".$file."',".$ultimoID);
}

?>