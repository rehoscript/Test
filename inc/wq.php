<?php
require_once 'Query.php';

$sql=new Query();
$sql->insert("test2",
             "campo",
             "4");
echo $sql->dameUltimo();

?>