<?php

/*
Site Settings!
*/
$title = "Virtual Trader";
$lang = "en"; //Site language - only en atm.
$results = 10; //Results per page

$mysql_host = "localhost";	 	
$mysql_user = "*****";	 	
$mysql_pass = "*****";	 	
$mysql_db = "virtualtrader";
/*
MySQL Settings!
*/

mysql_connect($mysql_host, $mysql_user, $mysql_pass) or die("Error! - Failed connecting to MySQL Server.");
mysql_select_db($mysql_db) or die("Error! - Failed selecting MySQL Database.");

session_start();

/*
This is a check to make sure a user doesnt access a page he isnt suppose to be able to view
*/

if(empty($_GET['p']) or !preg_match('/^[A-Za-z0-9]+$/',$_GET['p'])) {
  $_GET['p'] = "index";
}
if(!file_exists("./includes/pages/" . $_GET['p'] . ".php") or !file_exists("./includes/language/" . $lang . "/" . $_GET['p'] . ".php")) {
	$_GET['p'] = "index";
}
include $includeDir . "./includes/language/" . $lang . "/" . $_GET['p'] . ".php";
?>