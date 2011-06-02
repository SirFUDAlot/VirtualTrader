<?php session_start();
if($_SESSION['loggedin'] !== "true") { header("Location: login.php?msg=1"); exit; } ?>
<?php
include("includes/mysql.php");
$username = $_SESSION['username'];
$get_email = mysql_query("SELECT email FROM user_db WHERE username='$username'");
list($email) = mysql_fetch_row($get_email);
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

<h2>My Account</h2>
<div class="articles"> Username : <?php echo $username; ?><br />
  Password : **********<br />
  <br />
  Email Address : <?php echo $email; ?>
  <br />
  <br />
  <a href="changepass.php">Change Password</a> &gt;<br />
  <a href="changeemail.php">Change Email Address</a> &gt;
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