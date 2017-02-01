<?php
$dbname = 'kkurdziel';
$dbuser = 'kkurdziel';
$dbpass = 'testnt123';
//$dbhost = 'sirius.fmi.pk.edu.pl';
$dbhost = 'localhost';
if (mysqli_connect_errno()) {
    echo "Blad polaczenia z baza danych: " . mysqli_connect_error();
}
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

function getConnection() {
    global $connection;
    return $connection;
}

function getUserId() {
        $_COOKIE['id'] = mysqli_real_escape_string(getConnection(), $_COOKIE['id']);

        $session_arr = mysqli_fetch_assoc(mysqli_query(getConnection(),
            "select ses_us_id from session where id = '{$_COOKIE[id]}';"));
        return $session_arr['ses_us_id'];
}

function getUsername() {
    $_COOKIE['id'] = mysqli_real_escape_string(getConnection(), $_COOKIE['id']);

    $session_arr = mysqli_fetch_assoc(mysqli_query(getConnection(),
        "select username from session inner join user on session.ses_us_id = user.us_id 
        where id = '{$_COOKIE[id]}';"));
    return $session_arr['username'];
}

function getUserRole() {
    foreach($_COOKIE as $key=>$value) {
        $_COOKIE[$key] = mysqli_real_escape_string(getConnection(), $value);
    }
    $session_arr = mysqli_fetch_assoc(mysqli_query(getConnection(),
        "select role from session left join role_type on session.role_id = role_type.role_id
        where id = '{$_COOKIE[id]}' ;"));
    return $session_arr['role'];
}

function getIndexPath($role) {
    //header("Location : /~kokurd/test.php?asd=".$role)
    if($role == null) {
        return "/~kokurd/default/home.php";
    } else {
        return "/~kokurd/".$role."/home.php";
    }
}

?>