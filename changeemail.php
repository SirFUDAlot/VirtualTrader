<?php session_start();
if($_SESSION['loggedin'] !== "true") { header("Location: login.php?msg=1"); exit; } ?>
<?php
include("includes/mysql.php");
$username = $_SESSION['username'];

if($_POST)
{
	function isValidEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	
	$newemail = $_POST['email'];
	
	if(strlen($newemail) == 0) { $msg[] = "New email field is empty !"; }
	elseif(strlen($newemail) < 5) { $msg[] = "New email is too short !"; }
	elseif(strlen($newemail) > 150) { $msg[] = "New email is too long !"; }
	elseif(!isValidEmail($newemail)) { $msg[] = "New email is invalid !"; }
	
	if(count($msg) == 0)
	{
		$newemail = mysql_real_escape_string($newemail);
		$query = mysql_query("UPDATE user_db SET email='$newemail' WHERE username='$username'");
		$msg[] = "Email successfully changed !";
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

<h2>Change Email Address</h2>
<div class="articles">
  <form id="form1" method="post" action="">
  <?php if(isset($msg)) { echo "<span class=\"errormsg\">"; foreach($msg as $mssg) { echo "$mssg<br/>"; } echo "</span><br/>"; } ?>
    <table width="391" border="0">
      <tr>
        <td width="170" height="48">New Email :</td>
        <td width="130"><label for="newpass"></label>
          <input name="email" type="text" id="email" maxlength="150" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" value="Continue &gt;" /></td>
      </tr>
    </table>
  </form>
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