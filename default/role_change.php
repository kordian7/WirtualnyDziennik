<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";

createHead();
if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}

createMenu();
echo "<br>
<div class='main'>
Administrator
Witaj na stronie glownej
<br> 
Zalogowany uzytkownik o ID: ".getUserId()."

";

foreach($_SERVER as $key=>$value) {
    echo "<br/>".$key." : ".$value;
}
echo "</div>";
?>

<?php createFooter(); ?>
</body>
</html>