<?php



include("security.php");
include("security_level_check.php");
include("selections.php");

$file = "../crossdomain.xml";

$handle = fopen($file, "w") or die("Cannot open file: " . $file);

if($_COOKIE["security_level"] == "1" or $_COOKIE["security_level"] == "2")
{

    $data = "<?xml version=\"1.0\"?>\n";
    $data.= "<!DOCTYPE cross-domain-policy SYSTEM \"http://www.macromedia.com/xml/dtds/cross-domain-policy.dtd\">\n";
    $data.= "<cross-domain-policy>\n";
    $data.= "  <allow-access-from domain=\"itsecgames.com\" />\n";
    $data.= "</cross-domain-policy>";

}

else
{

    $data = "<?xml version=\"1.0\"?>\n";
    $data.= "<!DOCTYPE cross-domain-policy SYSTEM \"http://www.macromedia.com/xml/dtds/cross-domain-policy.dtd\">\n";
    $data.= "<cross-domain-policy>\n";
    $data.= "  <allow-access-from domain=\"*\" />\n";
    $data.= "</cross-domain-policy>";

}

fwrite($handle, $data);

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

    <h1>Cross-Domain Policy File (Flash)</h1>

    <p>Using an insecure cross-domain policy file could expose this site to various attacks.</p>
    
    <p>Check the cross-domain policy file, and try to the steal the <a href="secret.php" target="_blank">secret</a>...</p>
    
    <p>HINT: <a href="../evil/xdx.php" target="_blank">Flash</a> and Silverlight applications are the source of all evil!</p>

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