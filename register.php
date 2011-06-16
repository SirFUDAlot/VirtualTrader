<?php

session_start();

if($_SESSION['loggedin'] === "true") { header("Location: index.php"); exit; }

if($_POST)
{
	include("includes/mysql.php");
	
	function isValidEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
		
	$username = $_POST['username'];
	$password = $_POST['password'];
	$verifypassword = $_POST['verifypassword'];
	$email = $_POST['email'];
	$curr_date = date("d/m/y - H:i:s");
	
	if(strlen($username) === 0) { $msg[] = "Username field is empty !"; }
	elseif(strlen($username) > 30) { $msg[] = "Username is too long !"; }
	elseif(strlen($username) < 5) { $msg[] = "Username is too short !"; }
	if(strlen($password) === 0) { $msg[] = "Password field is empty !"; }
	elseif(strlen($password) > 30) { $msg[] = "Password is too long !"; }
	elseif(strlen($password) < 5) { $msg[] = "Password is too short !"; }
	if(strlen($verifypassword) === 0) { $msg[] = "Verify Password field is empty !"; }
	elseif(strlen($verifypassword) > 30) { $msg[] = "Verify Password is too long !"; }
	elseif(strlen($verifypassword) < 5) { $msg[] = "Verify Password is too short !"; }
	elseif($verifypassword !== $password) { $msg[] = "Passwords don't match !"; }
	if(strlen($email) === 0) { $msg[] = "Email field is empty !"; }
	elseif(strlen($email) > 200) { $msg[] = "Email is too long !"; }
	elseif(strlen($email) < 5) { $msg[] = "Email is too short !"; }
	elseif(!isValidEmail($email)) { $msg[] = "Email is invalid !"; }
	
	if(count($msg) === 0)
	{
		$username = mysql_real_escape_string($username);
		$username = addslashes($username);
		$username = htmlentities($username);
		$password = hash("SHA512", $password);
		$email = mysql_real_escape_string($email);
		$email = addslashes($email);
		
		$query1 = mysql_query("SELECT * FROM user_db WHERE username='$username'");
		if(mysql_num_rows($query1) > 0) { $msg[] = "Username is already used !"; }
		$query2 = mysql_query("SELECT * FROM user_db WHERE email='$email'");
		if(mysql_num_rows($query2) > 0) { $msg[] = "Email is already used !"; }
		
		if(count($msg) === 0)
		{
			$query3 = mysql_query("INSERT INTO user_db (username, password, email) VALUES ('$username', '$password', '$email')");
			
			$msg_from = "no-reply@virtualtrader.cuonic.tk";
			$msg_subj = "VirtualTrader - New Account Created";
			$msg_cont = "Hello !";
			$msg_cont .= "\r\n\r\n";
			$msg_cont .= "You have created a new account at VirtualTrader.cuonic.tk";
			$msg_cont .= "\r\n";
			$msg_cont .= "Here is a reminder of your account information :";
			$msg_cont .= "\r\n\r\n";
			$msg_cont .= "Username : $username";
			$msg_cont .= "\r\n";
			$msg_cont .= "Password : $verifypassword";
			$msg_cont .= "\r\n\r\n";
			$msg_cont .= "You can now login at http://virtualtrader.cuonic.tk";
			$msg_head = "From: " . $msg_from;
						
			mail($email, $msg_subj, $msg_cont, $msg_head);
			
			$msg[] = "Account Created !";
			$msg[] = "Account info has been sent to your email address";
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

<h2>Register</h2>
<div class="articles">
<br />
<?php if(isset($msg)) { echo "<div class=\"errormsg\">"; foreach($msg as $mssg) { echo "$mssg<br/>"; } echo "</div><br/>"; } ?>
  <form method="post" action="register.php">
    <table width="296" border="0">
      <tr>
        <td width="129">Username :</td>
        <td width="157"><label for="username"></label>
          <input name="username" type="text" id="username" maxlength="30" /></td>
      </tr>
      <tr>
        <td>Password :</td>
        <td><input name="password" type="password" id="password" maxlength="30" /></td>
      </tr>
      <tr>
        <td>Verify Password :</td>
        <td><label for="verifypassword"></label>
          <input name="verifypassword" type="password" id="verifypassword" maxlength="30" /></td>
      </tr>
      <tr>
        <td>Email :</td>
        <td><label for="email"></label>
          <input name="email" type="text" id="email" maxlength="30" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><br />          <input type="submit" value="Create new account &gt;" /></td>
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