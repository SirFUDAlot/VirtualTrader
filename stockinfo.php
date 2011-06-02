<?php session_start(); ?>
<?php if($_SESSION['loggedin'] !== "true") { header("Location: index.php"); exit; }
$stockcode = $_GET['code'];
include("includes/mysql.php");
$stockcode = addslashes($stockcode);
$stockcode = mysql_real_escape_string($stockcode);
$query1 = mysql_query("SELECT name FROM stocks_available WHERE stock='$stockcode'");
if(mysql_num_rows($query1) == 0) { $stockcode = "GOOG"; }
$query2 = mysql_query("SELECT name FROM stocks_available WHERE stock='$stockcode'");
list($stockfname) = mysql_fetch_row($query2);
include("includes/getstock.php");
$stockinfo = GetStockInfo($stockcode);
$username = $_SESSION['username'];

$stock_count_query = mysql_query("SELECT quantity FROM user_stocks WHERE username='$username' AND stock='$stockcode'");
if(mysql_num_rows($stock_count_query) == 0) { $stockcount = 0; } else { list($stockcount) = mysql_fetch_row($stock_count_query); }

?>
<?php
if($_POST)
{
	$stockcode = $_POST['code'];
	$action = $_POST['action'];
	$quantity = $_POST['quantity'];
	
	if($action == 'buy')
	{
		// User wants to BUY stocks
		if(strlen($stockcode) == 0) { $buymsg[] = "Stock Code field is empty !"; }
		if(strlen($quantity) == 0) { $buymsg[] = "Buy Quantity field is empty !"; }
		elseif(strlen($quantity) > 5) { $buymsg[] = "Buy Quantity is too long !"; }
		elseif(!is_numeric($quantity)) { $buymsg[] = "Buy Quantity is not a number !"; }
		
		if(count($buymsg) == 0)
		{	
			$balance_query = mysql_query("SELECT balance FROM user_db WHERE username='$username'");
			list($balance) = mysql_fetch_row($balance_query);
			
			$totalprice = $stockinfo['price'] * $quantity;
			$stockprice = $stockinfo['price'];
			if($totalprice > $balance) { $buymsg[] = "Not enough money !"; }
			else
			{
				$newbalance = $balance - $totalprice;
				$update_balance = mysql_query("UPDATE user_db SET balance='$newbalance' WHERE username='$username'");
				$quantity = mysql_real_escape_string($quantity);
				$stockcode = mysql_real_escape_string($stockcode);
				if($stockcount > 0)
				{
					$newquantity = $stockcount + $quantity;
					$update_stock_log = mysql_query("UPDATE user_stocks SET quantity='$newquantity', price='$stockprice' WHERE username='$username' AND stock='$stockcode'");
					$buymsg[] = "You have purchased $quantity $stockcode Stocks !";
				}
				else
				{
					$insert_stock_log = mysql_query("INSERT INTO user_stocks (username, stock, quantity, price) VALUES ('$username', '$stockcode', '$quantity', '$stockprice')");
					$buymsg[] = "You have purchased $quantity $stockcode Stocks !";
				}
			}
		}
	}
	elseif($action == 'sell')
	{
		// User wants to SELL stocks
		if(strlen($stockcode) == 0) { $sellmsg[] = "Stock Code field is empty !"; }
		if(strlen($quantity) == 0) { $sellmsg[] = "Sell Quantity field is empty !"; }
		elseif(strlen($quantity) > 5) { $sellmsg[] = "Sell Quantity is too long !"; }
		elseif(!is_numeric($quantity)) { $sellmsg[] = "Sell Quantity is not a number !"; }
		
		if(count($sellmsg) == 0)
		{
			$stockinfo = GetStockInfo($stockcode);
			
			$balance_query = mysql_query("SELECT balance FROM user_db WHERE username='$username'");
			list($balance) = mysql_fetch_row($balance_query);
			
			$totalprice = $stockinfo['price'] * $quantity;
			$newbalance = $balance + $totalprice;
			
			$stock_q_query = mysql_query("SELECT quantity FROM user_stocks WHERE username='$username' AND stock='$stockcode'");
			list($currquantity) = mysql_fetch_row($stock_q_query);
			
			if($quantity <= $currquantity)
			{
				$stockcode = mysql_real_escape_string($stockcode);
				$newquantity = $currquantity - $quantity;
				$update_balance_query = mysql_query("UPDATE user_db SET balance='$newbalance' WHERE username='$username'");
				if($newquantity == 0)
				{
					$delete_stock_log = mysql_query("DELETE FROM user_stocks WHERE username='$username' AND stock='$stockcode'");
					$sellmsg[] = "You have sold $quantity $stockcode Stocks !";
				}
				else
				{
					$update_stock_log = mysql_query("UPDATE user_stocks SET quantity='$newquantity' WHERE username='$username' AND stock='$stockcode'");
					$sellmsg[] = "You have sold $quantity $stockcode Stocks !";
				}
			}
		}
	}
	else
	{
		$buymsg[] = "Error !";
		$sellmsg[] = "Error !";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>VirtualTrader</title>
<meta http-equiv="Content-Language" content="English" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>
<body>

<div id="wrap">

<div id="header">
<h1><img src="images/logo.png" alt="" width="425" height="62" /></h1>
</div>

<div id="top"> </div>
<?php include("includes/menu.php"); ?>
<div id="content">
<div class="left"> 

<h2>Stock Info - <?php echo $stockfname; ?></h2>
<div class="articles"><img src="http://chart.finance.yahoo.com/t?s=<?php echo $stockcode; ?>&lang=en-US&region=US&width=550&height=200" width="550" height="200" /><br />
  <br />
  Stock Code : <?php echo $stockcode; ?><br />
  Current Price : <?php echo $stockinfo['price']; ?><br />
  Current Difference : <?php if(substr_count($stockinfo['diff'],'-')>0) { echo "<img src=\"images/down.png\" /> "; } else { echo "<img src=\"images/up.png\" /> "; } ?>
<?php echo $stockinfo['diff']; ?>
<br />
<br />
You have <?php echo $stockcount; ?> Stocks for this company : <br />
<br />
<form action="" method="post">
  Buy Quantity :
  <input name="code" type="hidden" id="code" value="<?php echo $stockcode; ?>" />
  <input name="action" type="hidden" id="action" value="buy" />
<input name="quantity" type="text" id="quantity" size="5" maxlength="10" />
  <input type="submit" value="Buy &gt;" />
<?php if(isset($buymsg)) { echo "<span class=\"errormsg\">"; foreach($buymsg as $mssg) { echo $mssg; } echo "</span>"; } ?></form>
<?php if($stockcount > 0)
{ ?>
<form action="" method="post">
  Sell Quantity :
  <input name="code" type="hidden" id="code" value="<?php echo $stockcode; ?>" />
  <input name="action" type="hidden" id="action" value="sell" />
<input name="quantity" type="text" id="quantity" size="5" maxlength="10" />
  <input type="submit" value="Sell &gt;" />
  <?php if(isset($sellmsg)) { echo "<span class=\"errormsg\">"; foreach($sellmsg as $mssg) { echo $mssg; } echo "</span>"; } ?>
</form>
<?php } ?>
<div id="result"> </div>
</div>
</div>

<?php include("includes/sidebar.php"); ?>
<div style="clear: both;"> </div>
</div>

<div id="bottom"> </div>
<?php include("includes/footer.php"); ?>
</div>

</body>
</html>