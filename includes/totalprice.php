<?php 
if($_GET) 
{
	$code = $_GET['code'];
	$quantity = $_GET['q'];
	
	include("mysql.php");
	
	$code = addslashes($code);
	$code = mysql_real_escape_string($code);
	
	$query1 = mysql_query("SELECT price FROM stocks_available WHERE stock='$code'");
	list($price) = mysql_fetch_row($query1);
	
	$totalprice = $price * $quantity;
	
	echo "$" . $totalprice;
}