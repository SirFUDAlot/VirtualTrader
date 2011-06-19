<?php

// Cron job to be added.. Run script every 5 minutes

set_time_limit(0);

include("mysql.php");
include("getstock.php");

// ---------------------------------------
// Update the MySQL Stocks Database
// ---------------------------------------

$stock_query = mysql_query("SELECT name, stock FROM stocks_available");

while(list($stockname, $stockcode) = mysql_fetch_row($stock_query))
{
	$stockinfo = GetStockInfo($stockcode);
	$stockprice = $stockinfo['price'];
	$stockdiff = $stockinfo['diff'];
	$stockdiff_perc = $stockinfo['diff_perc'];
	
	$update_query = mysql_query("UPDATE stocks_available SET price='$stockprice', diff='$stockdiff', diff_perc='$stockdiff_perc' WHERE stock='$stockcode'");	
}

// ---------------------------------------
// Remove expired reset hashes (Over 24 hours old)
// ---------------------------------------

$hash_query = mysql_query("SELECT username, resetdate FROM user_db WHERE resethash != '0'");

while(list($username, $resetdate) = mysql_fetch_row($hash_query))
{
	if(time() >= strtotime($resetdate) + 86400)
	{
		$update_query = mysql_query("UPDATE user_db SET resethash = '0', resetdate='0000-00-00 00:00:00' WHERE username='$username'");
	}
}
	
	
?>