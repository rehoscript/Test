<?php
require 'sources/Funciones.php';
//Se envia datos

        
        
        
if($_POST)
{
    //get Commits
    
   
        
    $arrayPOST    = json_decode($_POST['payload']);
    $arrayCommits = $arrayPOST ->commits;
    
    foreach ($arrayCommits as $commit) 
    {
        $author     = $commit->author;
        $mailAuthor = $author->email;
        $date       = $commit->timestamp;
        $nameCommit = $commit->message;

        
        //Insert Commits
        $sql = new Query('MOD');
        $sql->insert("commit",
             "fecha,auto,nombre",
             "'".$date."','".$mailAuthor."','".$nameCommit."'");
        
        $ultimoID = $sql->ultimoID("commit");
        //
        
        
        $arrayFilesAdded    = $commit->added;
        $arrayFilesModified = $commit->modified;
        
        foreach ($arrayFilesAdded as $file) 
        {
            $sql3 = new Query('MOD');
            $sql3->insert("archivos",
             "archivo,id_commit",
             "'".$file."',".$ultimoID);
        }
        foreach ($arrayFilesModified as $file) 
        {
            $sql2 = new Query('MOD');
            $sql2->insert("archivos",
             "archivo,id_commit",
             "'".$file."',".$ultimoID);
        }
    }
}
?>
