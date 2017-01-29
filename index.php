<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf8_polish_ci" />  
<title>Wirtualny dziennik</title>
</head>  
<body>  

<?php
include "loginUtils.php";
include "protected/menu.php";
createMenu($session_arr['ses_us_id']);

echo "
<div class='main' /> <br>
Witaj na stronie glownej
<br> 
Zalogowany uzytkownik o ID: ".$checkuser['ses_us_id'];

foreach($_SERVER as $key=>$value) {
    echo "<br/>".$key." : ".$value;
}

?>


</body>
</html>