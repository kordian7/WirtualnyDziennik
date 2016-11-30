<?php
include "baza.php";
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

foreach($_COOKIE as $key=>$value) {
	$_COOKIE[$key] = mysqli_real_escape_string($connection, $value);
}

if(isset($_COOKIE['id'])) {
	$checkuser = mysqli_fetch_assoc(mysqli_query($connection,
	"select ses_us_id from Session where id = '{$_COOKIE[id]}' and
	web ='{$_SERVER['HTTP_USER_AGENT']}' and ip = '{$_SERVER['REMOTE_ADDR']}';"));
	if(empty($checkuser['ses_us_id'])) {
		header("location:login.php");
		exit;
	} else
		$us_id = $checkuser['ses_us_id'];
	
	
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