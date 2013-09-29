<?php
require_once 'Query.php';

$sql=new Query();
//$sql->insert("test2",
//             "campo",
//             "6");

$sql->sql="SELECT * from test2";
$resultado= $sql->select("obj");

foreach ($res as $resultado)
{
    echo $res->campo;
    echo "<br/>";
    
}
//echo "<br/>";
//echo $sql->select("arr");
?>