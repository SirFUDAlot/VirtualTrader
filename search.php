<?php session_start(); ?>
<?php if($_SESSION['loggedin'] !== "true") { header("Location: index.php"); exit; }

if(isset($_GET['q']))
{
	include("includes/mysql.php");
	
	$search_q = $_GET['q'];
	$search_q = mysql_real_escape_string(htmlentities($search_q));
	
	$user_query = mysql_query("SELECT username FROM user_db WHERE username LIKE '$search_q%' OR email LIKE '$search_q%'");
	$stock_query = mysql_query("SELECT stock, name FROm stocks_available WHERE stock LIKE '$search_q%' OR name LIKE '$search_q%'");
	
	if(mysql_num_rows($user_query) > 0)
	{
		if(mysql_num_rows($user_query) > 1)
		{
			// More than 1 result on user search
			
			$count = mysql_num_rows($user_query);
			
			$msg[] = "<b>User search :</b><br/>";
			$msg[] = "<b>$count</b> results found";
			$msg[] = "<br/><br/>";
			
			$i = 1;
			
			while(list($username) = mysql_fetch_row($user_query))
			{
				$msg[] = $i . ". <b>$username</b> - <a href=\"userstocks.php?username=$username\">View this user's profile</a>";
				$msg[] = "<br/>";
				if($i === $count) { echo "<br/>"; } else { $i++; }
			}
			
			echo "<br/><br/>";
		}
		else 
		{
			// Only 1 result on user search
			
			$msg[] = "<b>User search :</b><br/>";
			$msg[] = "<b>1</b> result found";
			$msg[] = "<br/><br/>";
			
			list($username) = mysql_fetch_row($user_query);
			
			$msg[] = "1. <b>$username</b> - <a href=\"userstocks.php?username=$username\">View this user's profile</a><br/><br/>";
		}
	}
	else 
	{
		// 0 Results on user search
		$msg[] = "<b>User search :</b><br/>";
		$msg[] = "No results found !";
		$msg[] = "<br/><br/>";
	}
	if(mysql_num_rows($stock_query) > 0)
	{
		if(mysql_num_rows($stock_query) > 1)
		{
			// More than 1 result on Stock Search
			
			$count = mysql_num_rows($stock_query);
			
			$msg[] = "<b>Stock search :</b><br/>";
			$msg[] = "<b>$count</b> results found";
			$msg[] = "<br/><br/>";
			
			$i = 1;
			
			while(list($stockcode, $stockname) = mysql_fetch_row($stock_query))
			{
				$msg[] = $i . ". <b>$stockcode ($stockname)</b> - <a href=\"stockinfo.php?code=$stockcode\">View more info</a>";
				$msg[] = "<br/>";
				if($i === $count) { echo "<br/>"; } else { $i++; }
			}	
		}	
		else 
		{
			// Only 1 result on Stock Search
			
			$msg[] = "<b>Stock search :</b><br/>";
			$msg[] = "<b>1</b> result found";
			$msg[] = "<br/><br/>";
			
			list($stockcode, $stockname) = mysql_fetch_row($stock_query);
			
			$msg[] = "1. <b>$stockcode ($stockname)</b> - <a href=\"stockinfo.php?code=$stockcode\">View more info</a>";
		}
	}
	else 
	{
		// 0 Results on stock search
		$msg[] = "<b>Stock search :</b><br/>";
		$msg[] = "No results found !";
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

<h2>Search<?php if(isset($search_q)) { echo " - $search_q"; } ?></h2>
<div class="articles">
<?php if(isset($msg)) { foreach($msg as $mssg) { echo $mssg; } echo "<br/><br/>"; } ?>
<form method="get" action="search.php"><input type="text" name="q" maxlength="30" />  <input type="submit" value="Search >" /></form>
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