<?php session_start(); ?>
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

<h2>Welcome to VirtualTrader !</h2>
<div class="articles"> VirtualTrader is a virtual online game where you trade stocks using virtual money  and actual real time stocks via a web interface. The aim of the game is to make the biggest profit possible with your original 200 $.<br />
  <br />
  Users can keep track of their bank balance, stock values, and there is also a user leaderboard, showing the users with the most profit to date.
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