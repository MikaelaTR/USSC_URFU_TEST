<?php



include("security.php");
include("security_level_check.php");
include("selections.php");
include("functions_external.php");
include("connect_i.php");

function xss($data)
{

    switch($_COOKIE["security_level"])
    {

        case "0" :

            $data = no_check($data);
            break;

        case "1" :

            $data = xss_check_4($data);
            break;

        case "2" :

            $data = xss_check_3($data);
            break;

        default :

            $data = no_check($data);
            break;

    }

    return $data;

}

$ip_address = $_SERVER["REMOTE_ADDR"];
$user_agent = $_SERVER["HTTP_USER_AGENT"];


$sql = "INSERT INTO visitors (date, user_agent, ip_address) VALUES (now(), '" . xss(sqli_check_3($link, $user_agent)) . "', '" . $ip_address . "')";

$recordset = $link->query($sql);

if(!$recordset)
{

    die("Error: " . $link->error);

}


$line = "'" . date("y/m/d G.i:s", time()) . "', '" . $ip_address . "', '" . xss($user_agent) . "'" . "\r\n";     

$fp = fopen("logs/visitors.txt", "a");
fputs($fp, $line, 200);
fclose($fp);


$sql = "SELECT * FROM visitors ORDER by id DESC LIMIT 3";

$recordset = $link->query($sql);

if(!$recordset)
{

    die("Error: " . $link->error);

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

<title>USSC_stand - XSS</title>

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

    <h1>XSS - Stored (User-Agent)</h1>

    <p>Your IP address and User-Agent string have been logged into the database! <font size="2">(<a href="logs/visitors.txt" target="_blank">download</a> log file)</font></p>

    <p>An overview of our latest visitors:</p>

    <table id="table_yellow">

        <tr height="30" bgcolor="#ffb717" align="center">

            <td width="100"><b>Date</b></td>
            <td width="100"><b>IP Address</b></td>
            <td width="465"><b>User-Agent</b></td>

        </tr>

<?php

while($row = $recordset->fetch_object())
{

?>
        <tr height="40">

            <td align="center"><?php echo $row->date; ?></td>
            <td align="center"><?php echo $row->ip_address; ?></td>
            <td><?php echo $row->user_agent; ?></td>

        </tr>

<?php

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