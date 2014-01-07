<?php
require 'sources/Funciones.php';


if($_POST)
{
    
    $arrayPOST    = json_decode($_POST['payload']);
    $arrayCommits = $arrayPOST ->commits;
    
    foreach ($arrayCommits as $commit) 
    {
        $author     = $commit->author;
        $mailAuthor = $author->email;
        $date       = $commit->timestamp;
        $nameCommit = $commit->message;

        $ultimoID = insertCommit($date, $mailAuthor, $nameCommit);
        
        $arrayFilesAdded    = $commit->added;
        $arrayFilesModified = $commit->modified;
        
        foreach ($arrayFilesAdded as $file) 
        {
            insertFile($file, $ultimoID);
        }
        foreach ($arrayFilesModified as $file) 
        {
            insertFile($file, $ultimoID);
        }
    }
}
?>
