<?php

$dbname = 'kkurdziel';
$dbuser = 'kkurdziel';
$dbpass = 'testnt123';
$dbhost = 'sirius.fmi.pk.edu.pl';

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
  echo "Blad polaczenia z baza danych: " . mysqli_connect_error();
}


function getConnection() {
    global $connection;
    return $connection;
}

function getUserId() {
        $_COOKIE['id'] = mysqli_real_escape_string(getConnection(), $_COOKIE['id']);

        $session_arr = mysqli_fetch_assoc(mysqli_query(getConnection(),
            "select ses_us_id where id = {$_COOKIE[id]};"));
        return $session_arr['ses_us_id'];
}

function getUserRole() {
    foreach($_COOKIE as $key=>$value) {
        $_COOKIE[$key] = mysqli_real_escape_string(getConnection(), $value);
    }
    $session_arr = mysqli_fetch_assoc(mysqli_query(getConnection(),
        "select role from session left join role_type on session.role_id = role_type.role_id
        where id = {$_COOKIE[id]} ;"));
    return $session_arr['role'];
}

?>