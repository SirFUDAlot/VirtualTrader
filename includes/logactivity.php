<?php

include("mysql.php");

function LogActivity($username, $action, $stock, $quantity, $price, $bankbalance)
{
	$date = date("Y-m-d H:i:s");
	
	$query = mysql_query("INSERT INTO activity_log (username, action, stock, quantity, price, bankbalance, date) VALUES ('$username', '$action', '$stock', '$quantity', '$price', '$bankbalance', '$date')");
}

?>