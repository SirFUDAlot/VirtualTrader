<div id="menu">
<ul>
<li><a href="index.php">Home</a></li>
<?php if($_SESSION['loggedin'] === "true")
{
?>
<li><a href="stocks.php">Stocks List</a></li>
<li><a href="account.php">My Account</a></li>
<li><a href="logout.php">Logout</a></li>
<?php
}
else
{
?>
<li><a href="login.php">Login</a></li>
<li><a href="register.php">Register</a></li>
<?php
}
?>
</ul>
</div>