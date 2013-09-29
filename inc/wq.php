<?php
require_once 'Query.php';

$sql=new Query();
//$sql->insert("test2",
//             "campo",
//             "6");

$sql->sql="SELECT campo from test2";
echo $sql->select("obj");
//echo "<br/>";
//echo $sql->select("arr");
?>