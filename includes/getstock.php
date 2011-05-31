<?php

function GetStockInfo($stockname)
{
	$url = "http://download.finance.yahoo.com/d/quotes.csv?s=" . $stockname . "&f=sl1d1t1c1ohgv&e=.csv";

	$data = fopen($url, "r");

	$content =  fgetcsv($data, 1024);

	$stock_info['name'] = $content[0];
	$stock_info['price'] = $content[1];
	$stock_info['diff'] = $content[4];

	if($content[1] === "0.00" or $content[0] === "Missing Symbols List.")
	{
		$stock_info['name'] = "Stock";
		$stock_info['price'] = "Doesn't";
		$stock_info['diff'] = "Exist";
	}
	
	return $stock_info;
}
?>