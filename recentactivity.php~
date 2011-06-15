<?php session_start(); ?>
<?php if($_SESSION['loggedin'] !== "true") { header("Location: index.php"); exit; }

include("includes/mysql.php");

$username = $_SESSION['username'];
$format = "Y-m-d H:i:s";
$curr_date = date($format);
echo $curr_date . "<br/>";
$week_date = date($format, strtotime('-7 day' . $date));
echo $week_date;

$query1 = mysql_query("SELECT action, stock, quantity, price, date FROM activity_log WHERE username='$username' AND date >= '$week_date'");

$actions_count = mysql_num_rows($query1);

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

<h2>Recent Activity</h2>

<div class="articles">You have performed <?php echo $actions_count; ?> actions over the past week :<br />
  <br />
<?php while(list($action, $stockcode, $quantity, $price, $date) = mysql_fetch_row($query1))
{
	if($action == "-") { $action = "sold"; } else { $action = "purchased"; }
	echo "You $action $quantity $stockcode stocks for $$price - $date<br/>";
}
?>
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