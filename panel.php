<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf8_polish_ci" />  
<title>Wirtualny dziennik</title>
</head>  
<body>  
<a href="index.php">Homepage</a>
<a href="panel.php">Panel użytkownika</a>
<a href="?logout">Wyloguj</a>
<br/>
<?php
include "loginUtils.php";
echo '<br> Witaj w panelu użytkownika<br><br>';
$person = mysqli_fetch_assoc(mysqli_query($connection, "select pr_id, name, surname, pesel from person where pr_id = {$pr_id};"));
if(!empty($person['pr_id'])) {
	echo "Twoje dane: <br>

	Id: {$person['pr_id']} <br>
	Imie: {$person['name']} <br>
	Nazwisko: {$person['surname']} <br>
	Pesel: {$person['pesel']} <br>";
}
?>


</body>
</html>