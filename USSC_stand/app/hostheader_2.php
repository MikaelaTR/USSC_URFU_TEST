<?php



include("security.php");
include("security_level_check.php");
include("selections.php");
include("connect_i.php");
include("functions_external.php");
include("admin/settings.php");

$message = "";

if(isset($_POST["action"]))
{

    $email = $_POST["email"];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {

    $message = "<font color=\"red\">Please enter a valid e-mail address!</font>";

    }

    else
    {

        $email = mysqli_real_escape_string($link, $email);

        $sql = "SELECT * FROM users WHERE email = '" . $email . "'";




        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Error: " . $link->error);

        }





        $row = $recordset->fetch_object();


        if($row)
        {





            $login = $row->login;

            if($smtp_server != "")
            {

                ini_set( "SMTP", $smtp_server);




            }


            $reset_code = random_string();
            $reset_code = hash("sha1", $reset_code, false);





            $subject = "USSC_stand - Change Your Secret";


            if($_COOKIE["security_level"] != "1" && $_COOKIE["security_level"] != "2")
            {

                $server = $_SERVER["HTTP_HOST"];

            }


            else
            {

                $server = "itsecgames.com";

            }
            
            $sender = $smtp_sender;

            $email_enc = urlencode($email);

            $content = "Hello " . ucwords($login) . ",\n\n";
            $content.= "Click the link to reset and change your secret: http://" . $server . "/USSC_stand/secret_change.php?email=" . $email_enc . "&reset_code=" . $reset_code . "\n\n";
            $content.= "Greets from USSC_stand!";

            $status = @mail($email, $subject, $content, "From: $sender");

            if($status != true)
            {

                $message = "<font color=\"red\">An e-mail could not be send...</font>";





            }

            else
            {

                $sql = "UPDATE users SET reset_code = '" . $reset_code . "' WHERE email = '" . $email . "'";




                $recordset = $link->query($sql);

                if(!$recordset)
                {

                    die("Error: " . $link->error);

                }





                $message = "<font color=\"green\">An e-mail with a reset code has been sent.</font>";

            }

        }

        else
        {

            $message = "<font color=\"red\">Invalid user!</font>";

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

<title>USSC_stand - Host Header Attacks</title>

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

    <h1>Host Header Attack (Reset Poisoning)</h1>

    <p>Enter your e-mail to reset and change your secret.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <p><label for="email">E-mail:</label><br />
        <input type="text" id="email" name="email"></p>

        <button type="submit" name="action" value="reset">Reset</button>

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