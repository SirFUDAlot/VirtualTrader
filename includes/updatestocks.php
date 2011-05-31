<?php

set_time_limit(0);

include("mysql.php");
include("getstock.php");

$query1 = mysql_query("SELECT name, stock FROM stocks_available");

while(list($stockname, $stockcode) = mysql_fetch_row($query1))
{
	$stockinfo = GetStockInfo($stockcode);
	$stockprice = $stockinfo['price'];
	$stockdiff = $stockinfo['diff'];
	
	$update_query = mysql_query("UPDATE stocks_available SET price='$stockprice', diff='$stockdiff' WHERE stock='$stockcode'");	
}
	
	
?>