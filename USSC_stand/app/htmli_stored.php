<?php



include("security.php");
include("security_level_check.php");
include("selections.php");
include("functions_external.php");
include("connect_i.php");

$entry = "";
$owner = "";
$message = "";

function htmli($data)
{

    include("connect_i.php");

    switch($_COOKIE["security_level"])
    {

        case "0" :

            $data = sqli_check_3($link, $data);
            break;

        case "1" :

            $data = sqli_check_3($link, $data);

            break;

        case "2" :

            $data = sqli_check_3($link, $data);

            break;

        default :

            $data = sqli_check_3($link, $data);
            break;

    }

    return $data;

}

if(isset($_POST["entry_add"]))
{

    $entry = htmli($_POST["entry"]);
    $owner = $_SESSION["login"];

    if($entry == "")
    {

        $message =  "<font color=\"red\">Please enter some text...</font>";

    }

    else            
    { 

        $sql = "INSERT INTO blog (date, entry, owner) VALUES (now(),'" . $entry . "','" . $owner . "')";

        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Error: " . $link->error . "<br /><br />");

        }




        $message = "<font color=\"green\">Your entry was added to our blog!</font>";

    }

}

else
{

    if(isset($_POST["entry_delete"]))
    {

        $sql = "DELETE from blog WHERE owner = '" . $_SESSION["login"] . "'";

        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Error: " . $link->error . "<br /><br />");

        }




        $message = "<font color=\"green\">All your entries were deleted!</font>";

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

<title>USSC_stand - HTML Injection</title>

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

    <h1>HTML Injection - Stored (Blog)</h1>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

	<table>

            <tr>

                <td colspan="6"><p><textarea name="entry" id="entry" cols="80" rows="3"></textarea></p></td>

            </tr>

            <tr>

                <td width="79" align="left">

                    <button type="submit" name="blog" value="submit">Submit</button>

                </td>

                <td width="85" align="center">

                    <label for="entry_add">Add:</label>
                    <input type="checkbox" id="entry_add" name="entry_add" value="" checked="on">

                </td>

                <td width="100" align="center">

                    <label for="entry_all">Show all:</label>
                    <input type="checkbox" id="entry_all" name="entry_all" value="">

                </td>

                <td width="106" align="center">

                    <label for="entry_delete">Delete:</label>
                    <input type="checkbox" id="entry_delete" name="entry_delete" value="">

                </td>

                <td width="7"></td>

                <td align="left"><?php echo $message;?></td>

            </tr>

	</table>

    </form>

    <br />

    <table id="table_yellow">

        <tr height="30" bgcolor="#ffb717" align="center">

            <td width="20">#</td>
            <td width="100"><b>Owner</b></td>
            <td width="100"><b>Date</b></td>
            <td width="445"><b>Entry</b></td>

        </tr>

<?php



$entry_all = isset($_POST["entry_all"]) ? 1 : 0;

if($entry_all == false)
{

	$sql = "SELECT * FROM blog WHERE owner = '" . $_SESSION["login"] . "'";

}

else
{

	$sql = "SELECT * FROM blog";

}

$recordset = $link->query($sql);

if(!$recordset)
{



?>
        <tr height="50">

            <td colspan="4" width="665"><?php die("Error: " . $link->error);?></td>
            <!--
            <td></td>
            <td></td>
            <td></td>
            -->

        </tr>

<?php

}

while($row = $recordset->fetch_object())
{

    if($_COOKIE["security_level"] == "1" or $_COOKIE["security_level"] == "2")
    {

?>
        <tr height="40">

            <td align="center"><?php echo $row->id; ?></td>
            <td><?php echo $row->owner; ?></td>
            <td><?php echo $row->date; ?></td>
            <td><?php echo xss_check_3($row->entry); ?></td>

        </tr>

<?php

    }

    else
    {

?>
        <tr height="40">

            <td align="center"><?php echo $row->id; ?></td>
            <td><?php echo $row->owner; ?></td>
            <td><?php echo $row->date; ?></td>
            <td><?php echo $row->entry; ?></td>

        </tr>

<?php

    }

}

$recordset->close();

$link->close();

?>
    </table>

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