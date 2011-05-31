<?php if($_GET['auth'] !== "dev2011") { header("Location: index.php"); exit; }

if($_POST)
{
	include("mysql.php");
	$stockname = $_POST['stockname'];
	$stockcode = $_POST['stockcode'];
	
	$stockname = mysql_real_escape_string($stockname);
	$stockcode = mysql_real_escape_string($stockcode);
	$stockname = addslashes($stockname);
	$stockcode = addslashes($stockcode);
	
	$query1 = mysql_query("INSERT INTO stocks_available (name, stock) VALUES ('$stockname', '$stockcode')");
	$msg = "$stockname added to database !";
}

?>

<p>Insert New Stock :</p>
<?php if(isset($msg)) { echo $msg; echo "<br/>"; } ?>
<form name="form1" method="post" action="addstock.php?auth=dev2011">
  Stock Name : 
  <label for="stockname"></label>
  <input name="stockname" type="text" id="stockname" maxlength="50">
  (Ex: Google Inc.)<br>
  Stock Code : 
  <label for="stockcode"></label>
  <input name="stockcode" type="text" id="stockcode" maxlength="4"> 
  (Ex: GOOG)<br>
  <br>
  <input type="submit" value="Add Stock">
</form>
<p>&nbsp;</p>