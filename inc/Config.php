<?php
//   Date             Modified by         Change(s)
//   2013-09-24         HMP                 1.0

if($_SERVER["SERVER_NAME"] != "localhost")#en linea
	include("Config.server.php");
else
	include("Config.local.php");

?>