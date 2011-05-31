<?php session_start(); 
if($_SESSION['loggedin'] !== "true") { header("Location: login.php?msg=1"); exit; } ?>
<?php include("includes/mysql.php");
include("includes/getstock.php");

$pagediv = 10;

$query1 = "SELECT * FROM stocks_available";
$query1 = mysql_query($query1);

if($_GET)
{
	$page = $_GET['page'];
	if(!is_numeric($page)) { $page = "1"; $mysqlpage = "0"; } else { $page = mysql_real_escape_string($page); $mysqlpage = $page * 10 - 10; }
}
else
{
	$page = "1";
	$mysqlpage = "0";
}

$totalpages = mysql_num_rows($query1);
$totalpages = ceil($totalpages / $pagediv);

$i = 1;

while($i <= $totalpages)
{
	if($i == $page) { $numbering[] = " <a href=\"stocks.php?page=$i\">[$i]</a> "; }
	else { $numbering[] = " <a href=\"stocks.php?page=$i\">$i</a> "; }
	$i++;
}

$query2 = "SELECT name, stock, price, diff FROM stocks_available ORDER BY id ASC LIMIT $mysqlpage, 10";
$query2 = mysql_query($query2);

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

<h2>Stocks List</h2>
<div class="articles"> 
<table width="564">
<tr>
<td width="245">Name :</td>
<td width="70">Code :</td>
<td width="80">Value :</td>
<td width="113">Difference :</td>
<td width="32">&nbsp;</td>
</tr>
<?php while(list($stock_name, $stock_code, $stock_price, $stock_diff) = mysql_fetch_row($query2))
{
?>
<tr>
<td><?php echo $stock_name; ?></td>
<td><?php echo $stock_code; ?></td>
<td><?php echo $stock_price; ?></td>
<td><?php if(substr_count($stock_diff,'-')>0) { echo "<img src=\"images/down.png\" /> "; } else { echo "<img src=\"images/up.png\" /> "; } ?>
<?php echo $stock_diff; ?></td>
<td><a href="stockinfo.php?code=<?php echo $stock_code; ?>"><img src="images/info.png" alt="" width="16" height="16" border="0" /></a></td>
</tr>
<?php } ?>
</table>
<br />
<br />
Page : <?php foreach($numbering as $pageid) { echo $pageid; } ?></div>
</div>

<?php include("includes/sidebar.php"); ?>
<div style="clear: both;"> </div>
</div>

<div id="bottom"> </div>
<?php include("includes/footer.php"); ?>
</div>

</body>
</html>