<?php



include("security.php");
include("security_level_check.php");
include("selections.php");
include("functions_external.php");

function commandi($data)
{

    switch($_COOKIE["security_level"])
    {

        case "0" :

            $data = commandi_check_3($data);
            break;

        case "1" :

            $data = commandi_check_2($data);
            break;

        case "2" :

            $data = commandi_check_2($data);
            break;

        default :

            $data = commandi_check_3($data);
            break;

    }

    return $data;

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

<title>USSC_stand - Buffer Overflow</title>

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

    <h1>Buffer Overflow (Local)</h1>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]); ?>" method="POST">

        <p>

        <label for="title">Search for a movie:</label>
        <input type="text" id="title" name="title" size="25">    

        <button type="submit" name="action" value="search">Search</button> &nbsp;&nbsp;(<a href="http://sourceforge.net/projects/USSC_stand/files/bee-box/" target="_blank">bee-box</a> only)

        </p>

    </form>
    <?php

    if(isset($_POST["title"]))
    {

        $title = $_POST["title"];
	$title = commandi($title);

        if($title == "")
        {

            echo "<p><font color=\"red\">Please enter a title...</font></p>";

        }

        else
        {

            echo shell_exec("./apps/movie_search " . $title);

        }

    }

    else
    {

        echo "<p>HINT: \\x90*354 + \\x8f\\x92\\x04\\x08 + [payload]</p>";
        echo "<p>Thanks to David Bloom (@philophobia78) for developing the C++ BOF application!</p>";

    }
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