<?php

session_start();

if($_SESSION['loggedin'] === "true") { header("Location: index.php"); exit; }

if($_GET)
{
	$msgid = $_GET['msg'];
	if($msgid === "1") { $msg[] = "You need to login !"; }
}
if($_POST)
{
	include("includes/mysql.php");
		
	$username = $_POST['username'];
	$password = $_POST['password'];
	$curr_date = date("d/m/y - H:i:s");
	
	if(strlen($username) === 0) { $msg[] = "Username field is empty !"; }
	elseif(strlen($username) > 30) { $msg[] = "Username is too long !"; }
	elseif(strlen($username) < 5) { $msg[] = "Username is too short !"; }
	if(strlen($password) === 0) { $msg[] = "Password field is empty !"; }
	elseif(strlen($password) > 30) { $msg[] = "Password is too long !"; }
	elseif(strlen($password) < 5) { $msg[] = "Password is too short !"; }
	
	if(count($msg) === 0)
	{
		$username = mysql_real_escape_string($username);
		$username = addslashes($username);
		$password = hash("SHA512", $password);
		
		$query1 = mysql_query("SELECT password, lastlogin FROM user_db WHERE username='$username'");
		if(mysql_num_rows($query1) === 0) { $msg[] = "Username or password is incorrect !"; }
		else
		{
			list($db_password, $db_lastlogin) = mysql_fetch_row($query1);
			if($password === $db_password)
			{
				$_SESSION['loggedin'] = "true";
				$_SESSION['username'] = $username;
				$_SESSION['lastlogin'] = $db_lastlogin;
				
				$query2 = mysql_query("UPDATE user_db SET lastlogin='$curr_date' WHERE username='$username'");
				
				header("Location: index.php");
				exit;
			}
			else
			{
				$msg[] = "Username or password is incorrect !";
			}
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

<h2>Login</h2>
<div class="articles">
<br />
<?php if(isset($msg)) { echo "<div class=\"errormsg\">"; foreach($msg as $mssg) { echo "$mssg<br/>"; } echo "</div><br/>"; } ?>
  <form method="post" action="login.php">
    <table width="300" border="0">
      <tr>
        <td width="120">Username :</td>
        <td width="154"><label for="username"></label>
          <input name="username" type="text" id="username" maxlength="30" /></td>
      </tr>
      <tr>
        <td>Password :</td>
        <td><input name="password" type="password" id="password" maxlength="30" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><br />          <input type="submit" value="Login &gt;" /></td>
      </tr>
    </table>
  </form>
  <br />
  <a href="resetpass.php">Reset Password</a> ><br />
  <a href="register.php">Create new account</a> >
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