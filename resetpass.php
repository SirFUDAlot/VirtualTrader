<?php

session_start();

if($_SESSION['loggedin'] === "true") { header("Location: index.php"); exit; }

function genRandomString($length) {
   $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUXWXYZabcdefghijklmnopqrstuvwxyz';
   $string = "";    

   for ($p = 0; $p < $length; $p++) {
   	$string .= $characters[mt_rand(0, strlen($characters))];
   }

   return $string;
}

if($_GET)
{
	include("includes/mysql.php");
	
	$hash = $_GET['hash'];
	
	if(strlen($hash) == 0) { $msg[] = "Hash Field is empty !"; }
	elseif(strlen($hash) > 15) { $msg[] = "Hash is invalid !"; }
	elseif(strlen($hash) < 15) { $msg[] = "Hash is invalid !"; }
	
	echo strlen($hash);
	
	if(count($msg) == 0)
	{
		$hash = mysql_real_escape_string($hash);
		$query = mysql_query("SELECT username, email FROM user_db WHERE resethash='$resethash'");
		if(mysql_num_rows($query) == 0) { $msg[] = "Hash is incorrect !"; }
		else 
		{
			list($username, $email) = mysql_fetch_row($query);
			$newpass = genRandomString(10);
			$enc_newpass = hash("SHA512", $newpass);
			$query2 = mysql_query("UPDATE user_db SET password='$enc_newpass', resethash='0' WHERE username='$username'");
			
			$to  = $email;
			$subject = "VirtualTrader - Password Reset";
			$message = "Hello $username\n\n";
			$message .= "Your password on VirtualTrader has been reset\n\n";
			$message .= "Here is you new login information :\n\n";
			$message .= "Username : $username\n";
			$message .= "Password : $newpass\n\n";
			$message .= "To enhance user security, we demand that you change this password at your next login.\n\n";
			$message .= "You can login now at : http://virtualtrader.cuonic.tk/login.php";
			$header = "From: no-reply@virtualtrader.cuonic.tk";
			mail($to, $subject, $message, $header);
			
			$msg[] = "New password has been sent to your email address !";
		}
	}
}

if($_POST)
{
	include("includes/mysql.php");
	
	function isValidEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
		
	$email = $_POST['email'];
	
	if(strlen($email) === 0) { $msg[] = "Email Address field is empty !"; }
	elseif(strlen($email) > 200) { $msg[] = "Email Address is too long !"; }
	elseif(strlen($email) < 5) { $msg[] = "Email Address is too short !"; }
	elseif(!isValidEmail($email)) { $msg[] = "Email Address is invalid !"; }
	
	if(count($msg) === 0)
	{
		$email = mysql_real_escape_string($email);
		
		$query1 = mysql_query("SELECT username, resethash FROM user_db WHERE email='$email'");
		if(mysql_num_rows($query1) === 0) { $msg[] = "Email is incorrect !"; }
		else
		{
			list($username, $curr_resethash) = mysql_fetch_row($query1);
			if($curr_resethash == '0')
			{
				$resethash = genRandomString(15);

				$insert_query = mysql_query("UPDATE user_db SET resethash='$resethash' WHERE username='$username'");				
				
				$to = $email;
				$subject = "VirtualTrader - Password Reset Request";
				$message = "Hello $username\n\n";
				$message .= "You requested a password reset for your account at the VirtualTrader Website\n\n";
				$message .= "Please go to the following link to continue with this process :\n\n";
				$message .= "http://virtualtrader.cuonic.tk/resetpass.php?hash=$resethash";
				$headers = "From: no-reply@virtualtrader.cuonic.tk";
						
				mail($to, $subject, $message, $headers);
				
				$msg[] = "An email has just been sent to your inbox !";
			}
			else
			{
				$msg[] = "You have already requested a password reset !";
				$msg[] = "Please check you email inbox !";
				
				$to = $email;
				$subject = "VirtualTrader - Password Reset Request";
				$message = "Hello $username\n\n";
				$message .= "You requested a password reset for your account at the VirtualTrader Website\n\n";
				$message .= "Please go to the following link to continue with this process :\n\n";
				$message .= "http://virtualtrader.cuonic.tk/resetpass.php?hash=$curr_resethash";
				$headers = "From: no-reply@virtualtrader.cuonic.tk";
						
				mail($to, $subject, $message, $headers);
				
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

<h2>Reset Password</h2>
<div class="articles">
<br />
<?php if(isset($msg)) { echo "<div class=\"errormsg\">"; foreach($msg as $mssg) { echo "$mssg<br/>"; } echo "</div><br/>"; } ?>
  <form method="post" action="">
    <table width="300" border="0">
      <tr>
        <td width="120">Email :</td>
        <td width="154">
          <input name="email" type="text" maxlength="200" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><br />          <input type="submit" value="Continue &gt;" /></td>
      </tr>
    </table>
  </form>
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