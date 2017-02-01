<!DOCTYPE HTML>
<?php
include "/~kokurd/baza.php";

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");


foreach($_COOKIE as $key=>$value) {
    $_COOKIE[$key] = mysqli_real_escape_string($connection, $value);
}

if(isset($_COOKIE['id'])) {
    $checkuser = mysqli_fetch_assoc(mysqli_query($connection,
        "select ses_us_id from session where id = '{$_COOKIE[id]}' and
		web ='{$_SERVER['HTTP_USER_AGENT']}' and ip = '{$_SERVER['REMOTE_ADDR']}';"));
    if(!empty($checkuser['ses_us_id'])) {
        header("location:index.php");
        exit;
    } else {
        setcookie("id", null, -1);
        drawForm();
    }
}
else {
    drawForm();
}
if(!checkIfLogged()) {
header("Location: login.php");
}


<html>
<head>
<meta charset="utf-8">
<title>Logowanie</title>
<style>
html,body {
  height:100%;
  width:100%;
  margin:0;
}
body {
  display:flex;
}
form {
  margin:auto;/* nice thing of auto margin if display:flex; it center both horizontal and vertical :) */
	margin-top:10%;
  }
</style>
</head>

<body>
<br/>


	function drawForm() {
        echo
        '<form action="login_submit.php" method=post>
		
		<div style="padding-bottom:150px; text-align:center; font-size:28px; width:100%">
		Logowanie
		</div>';
        if($_GET['access'] == 'denied') {
            echo '<div style="padding-bottom:15px">
		Blad logowania
		</div>';
        }
        echo '
		<div style="padding-bottom:15px">
		Login: <input type=text name="username" required="true">
		</div>
		<div>
		Hasło: <input type=password name="password" required="true">
		</div>
		</br>
		<div style="text-align:center; padding-top:20px">
		<input  type=submit value="Zaloguj">
		</div>
	</form>';
    }
	?>
</body>
</html>