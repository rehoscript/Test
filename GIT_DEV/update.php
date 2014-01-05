<?php
require 'sources/Funciones.php';
//Se envia datos

        
        
        
if($_POST)
{
    //get Commits
    
   
        
    $arrayPOST    = $_POST['payload'];
    //$arrayCommits = $arrayPOST['commits'];
    
    foreach ($arrayPOST as $commit) 
    {
//        $author     = $commit->author;
//        $mailAuthor = $author['email'];
//        $date       = $commit->timestamp;
//        $nameCommit = $commit->message;
        $author     = 'asda';
        $mailAuthor = 'gato';
        $date       = 'now()';
        $nameCommit = 'soas';
        
        //Insert Commits
        $sql = new Query('MOD');
        $sql->insert("commit",
             "fecha,auto,nombre",
             "'".$date."','".$mailAuthor."','".$nameCommit."'");
        
        //$ultimoID = $sql->ultimoID("commit");
        //
//        $arrayFilesAdded    = $commit->added;
//        $arrayFilesModified = $commit->modified;
        
        foreach ($arrayFilesAdded as $file) 
        {
          //Inserts Files
//            $sql = new Query('SG');
//            $sql->insert("test2",
//             "campo",
//             "7");
        }
        foreach ($arrayFilesModified as $file) 
        {
//            $sql = new Query('SG');
//            $sql->insert("test2",
//             "campo",
//             "7");
        }
    }
}
?>
