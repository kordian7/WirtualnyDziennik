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

$user_role_result = mysqli_query($connection, "select role_id, role from v_user_role where us_id = {$us_id};");
if (mysqli_num_rows($user_role_result) < 2) {
    header("location:index.php");
    exit;
} else {
    echo '<br> Wybierz swoją role <br><br>';
    while($user_role_ass = mysqli_fetch_assoc($user_role_result)) {
        echo "".$user_role_ass['role_id']." ".$user_role_ass['role'] ;
        echo '<br/>';

    }


}

?>

<?php reateFooter(); ?>
</body>
</html>