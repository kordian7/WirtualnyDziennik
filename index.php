<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf8_polish_ci" />  
<title>Wirtualny dziennik</title>
</head>  
<body>  
<a href="index.php">Homepage</a>
<a href="login.php">Login</a>
<a href="logout.php">Wyloguj</a>
<br/>
<?php

if(isset($_COOKIE['logged']) && $_COOKIE['logged']==1) {
	echo "Zalogowany jako:".$_COOKIE['username'];

} else {
    echo "Niezalogowany";
	echo "Nacisnij <a href=\"login.php\"> Zaloguj </a> by sie zalogowac";
}


?>
</body>
</html>