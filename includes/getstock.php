<?php

function GetStockInfo($stockname)
	{
		$url = "http://www.google.com/ig/api?stock=" . $stockname;
		
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
	
		$xml = simplexml_load_string($data);
		$finance = $xml->xpath("/xml_api_reply/finance");
		
		$stockinfo['code'] = $finance[0]->symbol['data']; // Stock code name (ex: GOOG)
		$stockinfo['name'] = $finance[0]->company['data']; // Stock Company Name (ex: Google Inc.)
		$stockinfo['exchange'] = $finance[0]->exchange['data']; // Stock Exchange name (ex: Nasdaq)
		$stockinfo['price'] = $finance[0]->last['data']; // Stock price
		$stockinfo['diff'] = $finance[0]->change['data']; // Stock Difference
		$stockinfo['diff_perc'] = $finance[0]->perc_change['data']; // Stock difference in percent
		
		return $stockinfo;
    }
?>