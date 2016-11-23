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
include "baza.php";

if(isset($_COOKIE['logged']) && $_COOKIE['logged']==1) {
	$query = "SELECT us_id FROM User WHERE username = '".$_POST['username']."'";
	$res = mysql_query($query) or die("Nie moge uzyskac danych o uzytkownikach");
	$row = mysql_fetch_assoc($res);
	if(isset($row['us_id'])) {
		header('Location: add_student.php');
		die("Uzytkownik juz istnieje");
	}
	$query = "insert into User(name,surname, username) values('".$_POST['name']."','".$_POST['surname']."','".$_POST['username']."')";
	mysql_query($query) or die("Nie moge dodac uzytkownika");
	header('Location: add_student.php');
	die();
	
} else {
    echo "Niezalogowany";
	echo "Nacisnij <a href=\"login.php\"> Zaloguj </a> by sie zalogowac";
}


?>
</body>
</html>