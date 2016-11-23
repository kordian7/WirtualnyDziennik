<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf8_polish_ci" />  
<title>Wirtualny dziennik</title>
</head>  
<body>  
<a href="index.php">Homepage</a>
<a href="login.php">Login</a>
<?php
include "baza.php";

if(isset($_POST['username']) && isset($_POST['password'])) {
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	$checkuser = mysql_query("SELECT * FROM User where Username = '".$username."' and hashed_pwd = '".$password."'");
	if(mysql_num_rows($checkuser) == 1)
    {
        $row = mysql_fetch_array($checklogin);
         
        setcookie("username", $username);
        setcookie("logged", 1);
         
        echo "<h1>Success</h1>";
    }
    else
    {
        echo "<h1>Error</h1>";
        echo "<p>Zle dane logowania <a href=\"login.php\">Nacisnij by sprobowac ponownie</a>.</p>";
    }
};


?>
</body>
</html>