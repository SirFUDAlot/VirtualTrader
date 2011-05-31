<?php

$mysql_host = "localhost";
$mysql_user = "*****";
$mysql_pass = "*****";
$mysql_db = "virtualtrader";

$mysql_connect_1 = mysql_connect($mysql_host, $mysql_user, $mysql_pass);
if(!$mysql_connect_1) { echo "Error encountered connecting to MySQL Server... Exiting script"; exit; }

$mysql_connect_2 = mysql_select_db($mysql_db);
if(!$mysql_connect_1) { echo "Error encountered selecting database... Exiting script"; exit; }

?>
