<?php



include("security.php");
include("security_level_check.php");
include("selections.php");
include("functions_external.php");
include("connect_i.php");
include("admin/settings.php");

$message = "";

if($_COOKIE["security_level"] == "1" or $_COOKIE["security_level"] == "2")
{

    $message = "We currently have no cure for this bug. Try to configure SMTPS or IPSEC.";

}

if(isset($_POST["action"]))
{

    $login = $_SESSION["login"];




    $sql = "SELECT * FROM users WHERE login = '" . $login . "'";




    $recordset = $link->query($sql);

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }





    $row = $recordset->fetch_object();


    if($row)
    {

        if($smtp_server != "")
        {

            ini_set( "SMTP", $smtp_server);

        //Debugging


        }

        $secret = $row->secret;
        $email = $row->email;


        $subject = "USSC_stand - Your Secret";

        $sender = $smtp_sender;

        $content = "Hello " . ucwords($login) . ",\n\n";
        $content.= "Your secret: " . $secret . "\n\n";
        $content.= "Greets from USSC_stand!";

        $status = @mail($email, $subject, $content, "From: $sender");

        if($status != true)
        {

            $message = "<font color=\"red\">An e-mail could not be sent...</font>";





        }

        else
        {

            $message = "<font color=\"green\">An e-mail with your secret has been sent to " . $email . ".</font>";

        }

    }

}

?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Architects+Daughter">-->
<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
<script src="js/html5.js"></script>

<title>USSC_stand - Security Misconfiguration</title>

</head>

<body>

<header>

<h1>USSC_stand</h1>

<h2>Самое безопасное приложение в мире!</h2>

</header>

<div id="menu">

    <table>

        <tr>

            <td><a href="portal.php">Bugs</a></td>
            <td><a href="password_change.php">Change Password</a></td>
            <td><a href="user_extra.php">Create User</a></td>
            <td><a href="security_level_set.php">Set Security Level</a></td>
            <td><a href="reset.php" onclick="return confirm('All settings will be cleared. Are you sure?');">Reset</a></td>           
            <td><a href="credits.php">Credits</a></td>
            <td><a href="#" target="_blank">Blog</a></td>
            <td><a href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a></td>
            <td><font color="red">Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?></font></td>

        </tr>

    </table>

</div>

<div id="main">

    <h1>Man-in-the-Middle Attack (SMTP)</h1>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        Apparently you forgot your <button type="submit" name="action" value="mail">secret</button>

    </form>

    <br />
    <?php

    echo $message;

    $link->close();

    ?>

</div>

<div id="side">

    <a href="#" target="blank_" class="button"><img src="./images/twitter.png"></a>
    <a href="#" target="blank_" class="button"><img src="./images/linkedin.png"></a>
    <a href="#" target="blank_" class="button"><img src="./images/facebook.png"></a>
    <a href="#" target="blank_" class="button"><img src="./images/blogger.png"></a>

</div>




<div id="security_level">

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <label>Set your security level:</label><br />

        <select name="security_level">

            <option value="0">low</option>
            <option value="1">medium</option>
            <option value="2">high</option>

        </select>

        <button type="submit" name="form_security_level" value="submit">Set</button>
        <font size="4">Current: <b><?php echo $security_level?></b></font>

    </form>

</div>

<div id="bug">

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <label>Choose your bug:</label><br />

        <select name="bug">

<?php


foreach ($bugs as $key => $value)
{

   $bug = explode(",", trim($value));






   echo "<option value='$key'>$bug[0]</option>";

}

?>


        </select>

        <button type="submit" name="form_bug" value="submit">Hack</button>

    </form>

</div>

</body>

</html>