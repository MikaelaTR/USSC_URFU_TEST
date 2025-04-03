<?php



include("security.php");
include("security_level_check.php");
include("selections.php");
include("connect_i.php");

$message = "";
$db_reset = false;




setcookie("admin", "", time()-3600, "/", "", false, false);
setcookie("movie_genre", "", time()-3600, "/", "", false, false);
setcookie("secret", "", time()-3600, "/", "", false, false);
setcookie("top_security", "", time()-3600, "/", "", false, false);
setcookie("top_security_nossl", "", time()-3600, "/", "", false, false);
setcookie("top_security_ssl", "", time()-3600, "/", "", false, false);


if($_SESSION["admin"] != "1")
{

    $message = "<p>You don't have enough privileges for this action!</p><p>Contact your master bee...</p>";

    $link->close();

}

else
{




    $file = "documents/.htaccess";

    if(file_exists($file))
    {

        unlink($file);

    }


    $file = "passwords/accounts.txt";

    if(file_exists($file))
    {

        unlink($file);

    }


    $file = "ssii.shtml";

    if(file_exists($file))
    {

        unlink($file);

    }


    $file = "logs/visitors.txt";

    if(file_exists($file))
    {

        unlink($file);

    }




    if(isset($_GET["secret"]) && $_GET["secret"]== "USSC_stand")
    {


        $sql = "DROP DATABASE IF EXISTS USSC_stand";

        $recordset = $link->query($sql);          

        if(!$recordset)
        {

            die("Error: " . $link->error);

        }


        $sql = "CREATE DATABASE IF NOT EXISTS USSC_stand";

        $recordset = $link->query($sql);             

        if(!$recordset)
        {

            die("Error: " . $link->error);

        }


        mysqli_select_db($link,"USSC_stand");


        $sql = "DROP TABLE IF EXISTS users";

        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Error: " . $link->error);

        }


        $sql = "CREATE TABLE IF NOT EXISTS users (id int(10) NOT NULL AUTO_INCREMENT,login varchar(100) DEFAULT NULL,password varchar(100) DEFAULT NULL,";
        $sql.= "email varchar(100) DEFAULT NULL,secret varchar(100) DEFAULT NULL,activation_code varchar(100) DEFAULT NULL,activated tinyint(1) DEFAULT '0',";
        $sql.= "reset_code varchar(100) DEFAULT NULL,admin tinyint(1) DEFAULT '0',PRIMARY KEY (id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Error: " . $link->error);

        }


        $sql = "INSERT INTO users (login, password, email, secret, activation_code, activated, reset_code, admin) VALUES";
        $sql.= "('A.I.M.', '6885858486f31043e5839c735d99457f045affd0', 'USSC_stand-aim@mailinator.com', 'A.I.M. or Authentication Is Missing', NULL, 1, NULL, 1),";
        $sql.= "('bee', '6885858486f31043e5839c735d99457f045affd0', 'USSC_stand-bee@mailinator.com', 'Any bugs?', NULL, 1, NULL, 1)";

        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Error: " . $link->error);

        }

        $db_reset = true;

    }


    $sql = "DROP TABLE IF EXISTS blog";

    $recordset = $link->query($sql);

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }


    $sql = "CREATE TABLE IF NOT EXISTS blog (id int(10) NOT NULL AUTO_INCREMENT,owner varchar(100) DEFAULT NULL,";
    $sql.= "entry varchar(500) DEFAULT NULL,date datetime DEFAULT NULL,PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    $recordset = $link->query($sql);

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }
    

    $sql = "DROP TABLE IF EXISTS visitors";

    $recordset = $link->query($sql);             

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }


    $sql = "CREATE TABLE IF NOT EXISTS visitors (id int(10) NOT NULL AUTO_INCREMENT,ip_address varchar(50) DEFAULT NULL,";
    $sql.= "user_agent varchar(500) DEFAULT NULL,date datetime DEFAULT NULL,PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    $recordset = $link->query($sql);             

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }


    $sql = "DROP TABLE IF EXISTS movies";

    $recordset = $link->query($sql);

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }


    $sql = "CREATE TABLE IF NOT EXISTS movies (id int(10) NOT NULL AUTO_INCREMENT,title varchar(100) DEFAULT NULL,";
    $sql.= "release_year varchar(100) DEFAULT NULL,genre varchar(100) DEFAULT NULL,main_character varchar(100) DEFAULT NULL,";
    $sql.= "imdb varchar(100) DEFAULT NULL,tickets_stock int(10) DEFAULT NULL,PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    $recordset = $link->query($sql);

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }


    $sql = "INSERT INTO movies (title, release_year, genre, main_character, imdb, tickets_stock) VALUES ('G.I. Joe: Retaliation', '2013', 'action', 'Cobra Commander', 'tt1583421', 100),";
    $sql.= "('Iron Man', '2008', 'action', 'Tony Stark', 'tt0371746', 53),";
    $sql.= "('Man of Steel', '2013', 'action', 'Clark Kent', 'tt0770828', 78),";
    $sql.= "('Terminator Salvation', '2009', 'sci-fi', 'John Connor', 'tt0438488', 100),";
    $sql.= "('The Amazing Spider-Man', '2012', 'action', 'Peter Parker', 'tt0948470', 13),";
    $sql.= "('The Cabin in the Woods', '2011', 'horror', 'Some zombies', 'tt1259521', 666),";
    $sql.= "('The Dark Knight Rises', '2012', 'action', 'Bruce Wayne', 'tt1345836', 3),";
    $sql.= "('The Fast and the Furious', '2001', 'action', 'Brian O\'Connor', 'tt0232500', 40),";
    $sql.= "('The Incredible Hulk', '2008', 'action', 'Bruce Banner', 'tt0800080', 23),";
    $sql.= "('World War Z', '2013', 'horror', 'Gerry Lane', 'tt0816711', 0)";

    $recordset = $link->query($sql);

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }


    $sql = "DROP TABLE IF EXISTS heroes";

    $recordset = $link->query($sql);

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }


    $sql = "CREATE TABLE IF NOT EXISTS heroes (id int(10) NOT NULL AUTO_INCREMENT,login varchar(100) DEFAULT NULL,password varchar(100) DEFAULT NULL,secret varchar(100) DEFAULT NULL,";
    $sql.= "PRIMARY KEY (id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    $recordset = $link->query($sql);

    if(!$recordset)
    {

            die("Error: " . $link->error);

    }


    $sql = "INSERT INTO heroes (login, password, secret) VALUES";
    $sql.= "('neo', 'trinity', 'Oh why didn\'t I took that BLACK pill?'),";
    $sql.= "('alice', 'loveZombies', 'There\'s a cure!'),";
    $sql.= "('thor', 'Asgard', 'Oh, no... this is Earth... isn\'t it?'),";
    $sql.= "('wolverine', 'Log@N', 'What\'s a Magneto?'),";
    $sql.= "('johnny', 'm3ph1st0ph3l3s', 'I\'m the Ghost Rider!'),";
    $sql.= "('seline', 'm00n', 'It wasn\'t the Lycans. It was you.')";

    $recordset = $link->query($sql);         

    if(!$recordset)
    {

            die("Error: " . $link->error);

    }

    $link->close();

    if($db_reset == true)
    {


        $_SESSION = array();
        session_destroy();

        header("Location: login.php");

        exit;

    }

    $message = "<p>The application has been reset!</p>";

    /*







    $file = "file.sql";

    $fp    = fopen($file, 'r');
    $sql = fread($fp, filesize($file));
    fclose($fp);

    $link->query($sql);

    $recordset = $link->query($sql);

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }

    */

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

<title>USSC_stand - Reset</title>

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
            <td><font color="#ffb717">Reset</font></td>
            <td><a href="credits.php">Credits</a></td>
            <td><a href="#" target="_blank">Blog</a></td>
            <td><a href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a></td>
            <td><font color="red">Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?></font></td>

        </tr>

    </table>

</div>

<div id="main">

    <h1>Reset</h1>

    <?php echo $message ?>

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