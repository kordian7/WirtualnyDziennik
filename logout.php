<?php
include_once "login_utils.php";

if(!checkIfLogged()) {
    header("Location: login.php");
}
$_COOKIE['id'] = mysqli_real_escape_string(getConnection(), $_COOKIE['id']);
mysqli_query(getConnection(), "delete from session where id =
	'{$_COOKIE['id']}' and web = '{$_SERVER['HTTP_USER_AGENT']}';");
setcookie("id", 0 , time() - 1);
unset($_COOKIE['id']);
header("location:/~kokurd/");
?>