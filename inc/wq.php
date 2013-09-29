<?php
require_once 'Query.php';

$sql=new Query();
//$sql->insert("test2",
//             "campo",
//             "6");

$sql->sql="SELECT campo from test2";
$resultado= $sql->select("obj");


foreach ($resultado as $res)
{
    echo $res->campo;
    echo "<br/>";
    
}
echo "----------------------";
echo $sql->select("arr");
?>