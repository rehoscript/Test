<?php
require_once 'Query.php';

$sql=new Query();
//$sql->insert("test2",
//             "campo",
//             "6");

$sql->sql="SELECT campo from test2";
$resultado= $sql->select("obj");

echo var_dump($resultado);
foreach ($resultado as $res)
{
    echo $res;
    echo "<br/>";
    
}
//echo "<br/>";
//echo $sql->select("arr");
?>