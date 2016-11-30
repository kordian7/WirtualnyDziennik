<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf8_polish_ci" />  
</head>  
<body>  
<br/>

<form action="kart2.php" method=post>
		
		
		
		<div style="padding-bottom:15px">
		x1: <input type=text name="x1" required="true">
		</div>
		<div>
		x2: <input type=text name="x2" required="true">
		</div>
		</br>
		<div>
		Dok: <input type=text name="dok" required="true">
		</div>
		</br>
		<div >
		<input  type=submit value="Oblicz">
		</div>
	</form>

<?php
include "baza.php";

	//foreach ($_POST as $key=>$value) {
	//$_POST[$key] = mysqli_real_escape_string($connection, $value);
	//}
	
	if(isset($_POST['x1'])) {
		
		$x1 = $_POST['x1'];
		$x2 = $_POST['x2'];
		$dok = $_POST['dok'];
		$krok = abs(($x2 - $x1) / $dok);

		$suma = 0;
		
		for($i = 0; $i < $dok; $i++) {
			$newx = $x1 + $i*$krok;
			$suma += (abs((sin($newx) - cos($newx))) + abs((sin($newx + $krok) - cos($newx + $krok)))) * $krok / 2; 
		}
		
		
		$query = mysqli_query($connection, "insert into kart1(x1, x2, wynik) values( '{$x1}', '{$x2}', '{$suma}');");
		
		$qr = mysqli_query($connection, "select id, x1, x2, wynik from kart1 order by id desc;");
		
		while($q = mysqli_fetch_assoc($qr)) {
			echo "Id: " . $q['id'] . " x1: ". $q['x1'] . " x2: " . $q['x2'] . " wynik: " . $q['wynik'] . "<br>";
		};
			
	}
	
?>
</body>
</html>