<?php
include_once "baza.php";

function checkIfLogged() {

    //foreach($_COOKIE as $key=>$value) {
    //    $_COOKIE[$key] = mysqli_real_escape_string(getConnection(), $value);
    //}

    if(isset($_COOKIE['id'])) {
        $session_arr = mysqli_fetch_assoc(mysqli_query(getConnection(),
            "select ses_us_id from session where id = '{$_COOKIE[id]}' and
	          web ='{$_SERVER['HTTP_USER_AGENT']}' and ip = '{$_SERVER['REMOTE_ADDR']}';"));
        if(empty($session_arr['ses_us_id'])) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
    return false;
}

function checkUserRole($role){
    $arr = explode("/", $_SERVER['PHP_SELF'], 4);
    if (strpos($arr[2], '.php') !== false || $arr[2] === $role){
        return true;

    }
    return false;
}



?>