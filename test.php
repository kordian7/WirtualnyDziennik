<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf8_polish_ci" />  
<title>Wirtualny dziennik</title>
</head>  
<body>  
<a href="index.php">Homepage</a>
<a href="?logout">Wyloguj</a>
<br/>
<?php
include "loginUtils.php";
	echo '
	<form method=post action="add_student_submit.php">
		
		<div style="padding-bottom:100px; text-align:center; font-size:24px; width:100%">
		Dodawanie Nowego Uczniaa
		</div>
		<table>
			<tr>
				<td>
					Imie:
				</td>
				
				<td>
					<input type=text name="name" required="true">
				
				</td>
			</tr>
			
			<tr>
				<td>
					Nazwisko:
				</td>
				
				<td>
					<input type=text name="surname" required="true">
				
				</td>
			</tr>
			
			<tr>
				<td>
					Nazwa użytkownika:
				</td>
				
				<td>
					<input type=text name="username" required="true">
				</td>
			</tr>
			
			<tr>
			
			<td colspan=2 >
			<div style="text-align:center; padding-top:20px">
				<input  type=submit value="Dodaj ucznia">
			</div>
				
			</td>
			
			</tr>
			
		</table>
		
		
	</form>';


?>
</body>
</html>