<?php
session_start();

$dbname = 'kkurdziel';
$dbuser = 'kkurdziel';
$dbpass = 'testnt123';
$dbhost = 'sirius.fmi.pk.edu.pl';
$connect = mysql_connect($dbhost, $dbuser, $dbpass) or die("Nie mozna połączyć z '$dbhost'");
mysql_select_db($dbname) or die("Nie można otworzyć '$dbname'");
?>