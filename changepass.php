<?php session_start();
if($_SESSION['loggedin'] !== "true") { header("Location: login.php?msg=1"); exit; } ?>
<?php
include("includes/mysql.php");
$username = $_SESSION['username'];

if($_POST)
{
	$currpass = $_POST['currpass'];
	$newpass = $_POST['newpass'];
	$verifynewpass = $_POST['verifynewpass'];
	
	if(strlen($currpass) == 0) { $msg[] = "Current Password field is empty !"; }
	elseif(strlen($currpass) < 5) { $msg[] = "Current Password is too short !"; }
	elseif(strlen($currpass) > 30) { $msg[] = "Current Password is too long !"; }
	if(strlen($newpass) == 0) { $msg[] = "New Password field is empty !"; }
	elseif(strlen($newpass) < 5) { $msg[] = "New Password is too short !"; }
	elseif(strlen($newpass) > 30) { $msg[] = "New Password is too long !"; }
	if(strlen($verifynewpass) == 0) { $msg[] = "Repeat New Password field is empty !"; }
	elseif(strlen($verifynewpass) < 5) { $msg[] = "Repeat New Password is too short !"; }
	elseif(strlen($verifynewpass) > 30) { $msg[] = "Repeat New Password is too long !"; }
	elseif($newpassword !== $verifynewpassword) { $msg[] = "Passwords don't match !"; }
	
	if(count($msg) == 0)
	{
		$query = mysql_query("SELECT password FROM user_db WHERE username='$username'");
		list($db_password) = mysql_fetch_row($query);
		$enc_currpass = hash("SHA512", $currpass);
		
		if($db_password !== $enc_currpass) { $msg[] = "Current Password is incorrect !"; }
		else
		{
			$enc_newpass = hash("SHA512", $newpass);
			
			$query2 = mysql_query("UPDATE user_db SET password='$enc_newpass' WHERE username='$username'");
			$msg[] = "Password successfully changed !";
		}
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

<h2>Change Password</h2>
<div class="articles">
  <form id="form1" method="post" action="">
  <?php if(isset($msg)) { echo "<span class=\"errormsg\">"; foreach($msg as $mssg) { echo "$mssg<br/>"; } echo "</span><br/>"; } ?>
    <table width="391" border="0">
      <tr>
        <td width="170" height="45">Current Password :</td>
        <td width="130"><label for="newpass"></label>
          <input name="currpass" type="password" id="currpass" maxlength="30" /></td>
      </tr>
      <tr>
        <td>New Password :</td>
        <td><input name="newpass" type="password" id="newpass" maxlength="30" /></td>
      </tr>
      <tr>
        <td height="53">Repeat New Password :</td>
        <td><input name="verifynewpass" type="password" id="verifynewpass" maxlength="30" /></td>
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