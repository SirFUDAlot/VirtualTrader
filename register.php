<?php

session_start();

$msg = array();

if ($_SESSION['loggedin'] === "true") {
    header("Location: index.php");
    exit;
}

if ($_POST) {
    include("includes/mysql.php");
    function isValidEmail($email)
    {
        return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
    }

    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
    $verifypassword = mysql_real_escape_string($_POST['verifypassword']);
    $email = mysql_real_escape_string($_POST['email']);
    $curr_date = date("d/m/y - H:i:s");

    if (strlen($username) === 0) {
        $msg[] = "Username field is empty !";
    }
    elseif (strlen($username) > 30) {
        $msg[] = "Username is too long !";
    }
    elseif (strlen($username) < 5) {
        $msg[] = "Username is too short !";
    }
    if (strlen($password) === 0) {
        $msg[] = "Password field is empty !";
    }
    elseif (strlen($password) > 30) {
        $msg[] = "Password is too long !";
    }
    elseif (strlen($password) < 5) {
        $msg[] = "Password is too short !";
    }
    if (strlen($verifypassword) === 0) {
        $msg[] = "Verify Password field is empty !";
    }
    elseif (strlen($verifypassword) > 30) {
        $msg[] = "Verify Password is too long !";
    }
    elseif (strlen($verifypassword) < 5) {
        $msg[] = "Verify Password is too short !";
    }
    elseif ($verifypassword !== $password) {
        $msg[] = "Passwords don't match !";
    }
    if (strlen($email) === 0) {
        $msg[] = "Email field is empty !";
    }
    elseif (strlen($email) > 200) {
        $msg[] = "Email is too long !";
    }
    elseif (strlen($email) < 5) {
        $msg[] = "Email is too short !";
    }
    elseif (!isValidEmail($email)) {
        $msg[] = "Email is invalid !";
    }


    if (count($msg) === 0) {
        $query1 = mysql_query("SELECT * FROM user_db WHERE username='$username'");
        if (mysql_num_rows($query1) > 0) {
            $msg[] = "Username is already used !";
        }
        $query2 = mysql_query("SELECT * FROM user_db WHERE email='$email'");
        if (mysql_num_rows($query2) > 0) {
            $msg[] = "Email is already used !";
        }
        if (count($msg) === 0) {
            $hashedPass = hash("SHA512", $password);
            $activationKey = md5(microtime());
            $query3 = mysql_query("INSERT INTO user_db (`username`, `password`, `email`, `activationKey`, `active`) VALUES ('$username', '$hashedPass', '$email', '$activationKey', '0')") or die(mysql_error());

            $msg_from = "no-reply@virtualtrader.cuonic.tk";
            $msg_subj = "VirtualTrader - New Account Created";
            $message =
                    "Hello !
                        <br><br>
                        You have created a new account at VirtualTrader.cuoinic.tk
                        <br>
                        Here is a reminder of your account information :
                        <br><br>
                        Username : ' . $username . '
                        <br>
                        Password : ' . $verifypassword . '
                        <br><br>
                        Please click this link to activate your account:
                        <br>
                        <a href=\"http://virtualtrader.cuonic.tk/register.php?key=' . $activationKey . '&username=' . $username . '\">http://virtualtrader.cuonic.tk/register.php?key=' . $activationKey . '&username=' . $username . '</a>
                        <br><br>
                        Regards,
                        <br>
                        VirtualTrader Team
            ";
            $msg_head = "From: $msg_from" . "\r\n";
            $msg_head .= 'MIME-Version: 1.0' . "\r\n";
            $msg_head .= 'Content-type: text/html;' . "\r\n";
            mail($email, $msg_subj, $message, $msg_head);

            $msg[] = "Account Created !";
            $msg[] = "Account info has been sent to your email address";
        }
    }
} else if ($_GET && isset($_GET['key']) && !empty($_GET['key']) && isset($_GET['username']) && !empty($_GET['username'])) {

    include("includes/mysql.php");

    $username = mysql_real_escape_string($_GET['username']);
    $activationKey = mysql_real_escape_string($_GET['key']);

    $find = mysql_query("SELECT * FROM user_db WHERE `username`='$username' AND `activationKey`='$activationKey'") or die(mysql_error());
    $result = mysql_num_rows($find);
    $row = mysql_fetch_object($find);
    $active = $row->active;
    if ($active == 0 && $result > 0) {
        mysql_query("UPDATE user_db SET active='1' WHERE `username`='$username' AND `activationKey`='$activationKey' AND `active`='0'") or die(mysql_error());
        $msg = "Your account has been activated!";
    } else if ($active == 1 && $result > 0) {
        $msg = "Account is already active!";
    } else {
        $msg = "Invalid activation code!";
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>VirtualTrader</title>
    <meta http-equiv="Content-Language" content="English"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
</head>
<body>

<div id="wrap">

    <div id="header">
        <h1><img src="images/logo.png" alt="" width="425" height="62"/></h1>
    </div>

    <div id="top"></div>
    <?php include("includes/menu.php"); ?>
    <div id="content">
        <div class="left">

            <h2>Register</h2>

            <div class="articles">
                <br/>
                <?php if (!$_GET) {
                if (isset($msg)) {
                    echo "<div class=\"errormsg\">";
                    foreach ($msg as $mssg) {
                        echo "$mssg<br/>";
                    }
                    echo "</div><br/>";
                } ?>
                <form method="post" action="register.php">
                    <table width="296" border="0">
                        <tr>
                            <td width="129">Username :</td>
                            <td width="157"><label for="username"></label>
                                <input name="username" type="text" id="username" maxlength="30"/></td>
                        </tr>
                        <tr>
                            <td>Password :</td>
                            <td><input name="password" type="password" id="password" maxlength="30"/></td>
                        </tr>
                        <tr>
                            <td>Verify Password :</td>
                            <td><label for="verifypassword"></label>
                                <input name="verifypassword" type="password" id="verifypassword" maxlength="30"/></td>
                        </tr>
                        <tr>
                            <td>Email :</td>
                            <td><label for="email"></label>
                                <input name="email" type="text" id="email" maxlength="30"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><br/> <input type="submit" value="Create new account &gt;"/></td>
                        </tr>
                    </table>
                </form>
                <?php } else {
                echo "<div class=\"errormsg\">$msg</div><br/>";
            } ""?>

            </div>
        </div>

        <?php include("includes/sidebar.php"); ?>
        <div style="clear: both;"></div>
    </div>

    <div id="bottom"></div>
    <?php include("includes/footer.php"); ?>
</div>

</body>
</html>