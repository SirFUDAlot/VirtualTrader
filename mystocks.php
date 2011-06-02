<?php session_start(); ?>
<?php if($_SESSION['loggedin'] !== "true") { header("Location: index.php"); exit; }

include("includes/mysql.php");

$username = $_SESSION['username'];

$query1 = mysql_query("SELECT quantity FROM user_stocks WHERE username='$username'");

$totalquantity = 0;
$companies = 0;

while(list($quantity) = mysql_fetch_row($query1))
{
	$totalquantity = $totalquantity + $quantity;
	$companies++;
}

$query2 = mysql_query("SELECT stock, quantity, price FROM user_stocks WHERE username='$username'");

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

<h2>My Stocks</h2>

<div class="articles"><?php if(mysql_num_rows($query1) > 0)
{
?>In total you  have <?php echo $totalquantity; ?> stocks in <?php echo $companies; ?> different companies !<br />
  <br />
  <table width="560" border="0">
    <tr>
      <td width="106"><b>Stock Name :</b></td>
      <td width="76"><b>Quantity :</b></td>
      <td width="108"><b>Purchase Value :</b></td>
      <td width="113"><b>Current Value :</b></td>
      <td width="82"><b>Difference :</b></td>
      <td width="35"><b>&nbsp;</b></td>
    </tr>
  
<?php while(list($stockcode, $stockquantity, $previousprice) = mysql_fetch_row($query2))
{
	$currprice_query = mysql_query("SELECT price FROM stocks_available WHERE stock='$stockcode'");
	list($currprice) = mysql_fetch_row($currprice_query);
	$difference = $currprice - $previousprice;
	if(substr_count($difference,'-')>0) { $difference = "- " . str_replace("-", "", $difference); } else { $difference = "+ " . $difference; }
?>
    <tr>
      <td><?php echo $stockcode; ?></td>
      <td><?php echo $stockquantity; ?></td>
      <td><?php echo $previousprice; ?></td>
      <td><?php echo $currprice; ?></td>
      <td><?php echo $difference; ?></td>
      <td><a href="stockinfo.php?code=<?php echo $stockcode; ?>"><img src="images/info.png" alt="" width="16" height="16" /></a></td>
    </tr>
<?php } ?>
  </table>
  <?php } else { echo "You haven't got any stocks !"; } ?>
<br />
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