<?php

$dbname = 'kkurdziel';
$dbuser = 'kkurdziel';
$dbpass = 'testnt123';
$dbhost = 'sirius.fmi.pk.edu.pl';

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
  echo "Blad polaczenia z baza danych: " . mysqli_connect_error();
}
?>