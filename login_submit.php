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

foreach ($_POST as $key=>$value) {
	$_POST[$key] = mysqli_real_escape_string($connection, $value);
}

if(isset($_POST['username'])) {
	$query = mysqli_query($connection, "SELECT count(*) cnt, us_id 
	FROM User where Username = '{$_POST['username']}' and hashed_pwd = '".md5($_POST['password'])."';");
	$checkuser = mysqli_fetch_assoc($query);
	
	if($checkuser['cnt']) {
		$id = md5(rand(-10000, 10000) . microtime()) . md5(crc32(microtime()) . 
			$_SERVER['REMOTE_ADDR']);
		mysqli_query($connection, "delete from Session where ses_us_id = '{$checkuser['us_id']}';");
		mysqli_query($connection, "insert into Session(ses_us_id, id, ip, web) values
		({$checkuser['us_id']}, '{$id}', '{$_SERVER['REMOTE_ADDR']}', '{$_SERVER['HTTP_USER_AGENT']}');");
		if(mysqli_errno($connection)) {
			echo "blad przy logowaniu!";
			header("location:login.php");
			exit;
		} else {
			setcookie("id", $id);
			echo "<br>zalogowano";
			header("location:index.php");
			exit;
			// przekierowanie
		}
		
		
	} else {
		echo "zle dane logowania";
		header("location:login.php?access=denied");
		exit;
	}
 
	
} else {
	header("location:login.php");
	exit;
};


?>
</body>
</html>