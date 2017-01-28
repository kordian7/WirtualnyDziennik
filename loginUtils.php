<?php
include "baza.php";
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

foreach($_COOKIE as $key=>$value) {
	$_COOKIE[$key] = mysqli_real_escape_string($connection, $value);
}

if(isset($_COOKIE['id'])) {
	$session_arr = mysqli_fetch_assoc(mysqli_query($connection,
	"select ses_us_id from session where id = '{$_COOKIE[id]}' and
	web ='{$_SERVER['HTTP_USER_AGENT']}' and ip = '{$_SERVER['REMOTE_ADDR']}';"));
	if(empty($session_arr['ses_us_id'])) {
		header("location:login.php");
		exit;
	} else {
        $us_id = $session_arr['ses_us_id'];
        $person = mysqli_fetch_assoc(mysqli_query($connection,
            "select pr_id from user where us_id = '{$us_id}';"));
        $pr_id = $person['pr_id'];
    }
	
} else {
	header("location:login.php");
	exit;
}

if(isset($_GET['logout'])) {
	mysqli_query($connection, "delete from session where id =
		'{$_COOKIE['id']}' and web = '{$_SERVER['HTTP_USER_AGENT']}';");
	setcookie("id", 0 , time() - 1);
	unset($_COOKIE['id']);
	header("location:login.php");
	exit;
}


?>