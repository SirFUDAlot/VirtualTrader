<div class="right"> 
<?php if($_SESSION['loggedin'] === "true") { ?>
<?php
include("mysql.php");
$username = $_SESSION['username'];
$balance_query = mysql_query("SELECT balance FROM user_db WHERE username='$username'");
list($balance) = mysql_fetch_row($balance_query); ?>
<h2>Welcome <?php echo $_SESSION['username']; ?></h2>
<ul>
<li>Last Login :</li>
<li><?php echo $_SESSION['lastlogin']; ?></a></li>
<br />
<li>Your Balance :</li>
<li><?php echo "$ $balance"; ?></li>
</ul>
<?php }
else
{ ?>
<h2></h2>
<ul>
</ul>
<?php } ?>
</div>