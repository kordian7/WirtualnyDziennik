<!DOCTYPE HTML>

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
	<?php 
	if(isset($_COOKIE['logged']) && $_COOKIE['logged']==1)	{
		echo "Juz zalogowany";
	} else {
	echo	
	'<form action="login_submit.php" method=post>
		
		<div style="padding-bottom:150px; text-align:center; font-size:28px; width:100%">
		Logowanie
		</div>
		
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