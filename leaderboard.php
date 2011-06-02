<?php session_start(); ?>
<?php if($_SESSION['loggedin'] !== "true") { header("Location: index.php"); exit; }

include("includes/mysql.php");

$username = $_SESSION['username'];

$query1 = mysql_query("SELECT username, balance FROM user_db ORDER BY balance DESC LIMIT 0,10");


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

<h2>User Leaderboard - Top 10</h2>

<div class="articles">Here are the top 10 users. Ranking is based on the user's bank balance<br />
  <br />
  <table width="558" border="0">
    <tr>
      <td width="74"><b>Position :</b></td>
      <td width="140"><b>Username :</b></td>
      <td width="147"><b>Bank Balance :</b></td>
      <td width="135"><b>Stock Amount :</b></td>
      <td width="40"><b>&nbsp;</b></td>
    </tr>
  
<?php 
$i = 1;
while(list($db_username, $db_balance) = mysql_fetch_row($query1))
{
	$totalquantity = 0;
	$query2 = mysql_query("SELECT quantity FROM user_stocks WHERE username='$db_username'");
	while(list($stockquantity) = mysql_fetch_row($query2)) { $totalquantity = $totalquantity + $stockquantity; }
?>
    <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo $db_username; ?></td>
      <td>$ <?php echo $db_balance; ?></td>
      <td><?php echo $totalquantity; ?></td>
      <td><a href="userstocks.php?username=<?php echo $db_username; ?>"><img src="images/info.png" /></a></td>
    </tr>
<?php $i++; } ?>
  </table>
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