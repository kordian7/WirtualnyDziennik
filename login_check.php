<?php
/**
 * Created by PhpStorm.
 * User: Kordian
 * Date: 2017-02-02
 * Time: 21:54
 */
header('Content-Type: text/html; charset=UTF-8');
require_once 'baza.php';

if(isset($_POST['login'])) {
    if(checkIfLoginExists($_POST['login']))
        echo "Zajęty";
    else
        echo "Dostępny";
}


?>