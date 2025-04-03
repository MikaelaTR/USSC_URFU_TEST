<?php


include("security.php");
include("security_level_check.php");
include("selections.php");
include("admin/settings.php");

$message = "";

if(isset($_POST["form"]))
{

    if($_COOKIE["security_level"] == "1" or $_COOKIE["security_level"] == "2")
    {

        if(isset($_SESSION["captcha"]) && ($_POST["captcha_user"] == $_SESSION["captcha"]))
        {

            if($_POST["login"] == $login && $_POST["password"] == $password)
            {

                $message = "<font color=\"green\">Successful login!</font>";

            }

            else
            {

                $message = "<font color=\"red\">Invalid credentials! Did you forgot your password?</font>";

            }

        }

        else   
        {

            $message = "<font color=\"red\">Incorrect CAPTCHA!</font>";

        }

    }

    else
    {

        if($_POST["captcha_user"] == $_SESSION["captcha"])
        {

            if($_POST["login"] == $login && $_POST["password"] == $password)
            {

                $message = "<font color=\"green\">Successful login!</font>";

            }

            else
            {

                $message = "<font color=\"red\">Invalid credentials! Did you forgot your password?</font>";

            }

        }

        else
        {

            $message = "<font color=\"red\">Incorrect CAPTCHA!</font>";

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

<title>Broken Authentication</title>

</head>

<body>
 
<header>

<h1>USSC_stand</h1>

<h2>Самое защищенное приложение в истории!!!</h2>

</header>

<div id="menu">

    <table>

        <tr>

            <td><a href="portal.php">Bugs</a></td>
            <td><a href="password_change.php">Change Password</a></td>
            <td><a href="user_extra.php">Create User</a></td>
            <td><a href="security_level_set.php">Set Security Level</a></td>
            <td><a href="reset.php" onclick="return confirm('All settings will be cleared. Are you sure?');">Reset</a></td>
            <td><a href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a></td>
            <td><font color="red">Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?></font></td>

        </tr>

    </table>

</div>

<div id="main">

    <h1>Broken Auth. - CAPTCHA Bypassing</h1>

    <p>Enter your credentials <i>(bee/bug)</i>.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <p><label for="login">Login:</label><br />
        <input type="text" id="login" name="login" size="20" autocomplete="off" /></p>

        <p><label for="password">Password:</label><br />
        <input type="password" id="password" name="password" size="20" autocomplete="off" /></p>

        <p><iframe src="captcha_box.php" scrolling="no" frameborder="0" height="70" width="350"></iframe></p>

        <p><label for="captcha_user">Re-enter CAPTCHA:</label><br />
        <input type="text" id="captcha_user" name="captcha_user" value="" autocomplete="off" /></p>

        <button type="submit" name="form" value="submit">Login</button>
        
        &nbsp;&nbsp;&nbsp;<?php echo $message . "\n";?>

    </form>

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