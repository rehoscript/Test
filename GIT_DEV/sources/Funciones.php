<?php

include("Utilidades.php");
require 'Query.php';

function generarListadoCommits($correo)
{
    $sql = new Query('MOD');
    $sql->sql = "SELECT id FROM commit WHERE auto='".$correo."'";
    $sql->sql = "SELECT id from commit";
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
            $sql5 = new Query('MOD');
            $sql5->sql = "SELECT id FROM archivos  WHERE id_commit = ".$commit->id;
            $resultado2 = $sql5->select();
            
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

?>