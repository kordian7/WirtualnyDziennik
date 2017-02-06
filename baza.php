<?php
include_once "utils.php";
$dbname = 'kkurdziel';
$dbuser = 'kkurdziel';
$dbpass = 'testnt123';
//$dbhost = 'sirius.fmi.pk.edu.pl';
$dbhost = 'localhost';
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
    echo "
            <div style='margin-top: 100px; text-align: center' class=\"alert alert-danger \">
            
            <strong>Database Error</strong>  Problem z połączeniem z bazą danych
            </div>
        ";
}
mysqli_query($connection, "set names 'utf8' collate 'utf8_unicode_ci'");

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

function getUserInfo($us_id) {
    $query = mysqli_query(getConnection(), "SELECT us_id, username, hashed_pwd, pr_id 
	FROM user where us_id = {$us_id} ;");
    $userInfo = mysqli_fetch_assoc($query);
    return $userInfo;
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

function getAvailableRoles() {
    $user_role_result = mysqli_query(getConnection(), "select role_id, role from v_user_role where us_id = ".getUserId().";");
    while($user_role_ass = mysqli_fetch_assoc($user_role_result)) {
        $user_roles[$user_role_ass['role_id']] = $user_role_ass['role'];
    }
    return $user_roles;
}

function getPeopleWithNoUser() {
    $people_result = mysqli_query(getConnection(), "select pr_id, name, surname, pesel, mail from v_person_user where username is null;");
    return $people_result;
}

function getStudents() {
    $students_result = mysqli_query(getConnection(), "select st_id, name, surname, pesel from v_student;");
    return $students_result;
}

function getPersonId($us_id) {
    $person_result = mysqli_fetch_assoc(mysqli_query(getConnection(), "select pr_id from user where us_id = ".$us_id.";"));
    $pr_id = $person_result['pr_id'];
    return $pr_id;
}

function getPersonInfo($p_id) {
    $people_result = mysqli_fetch_assoc(mysqli_query(getConnection(), "select pr_id, name, surname, pesel, mail, phone_nr from person where pr_id = ".$p_id.";"));
    foreach ($people_result as $key=>$value) {
        $people_result[$key] = strip_tags($value);
    }

    return $people_result;
}

function checkIfLoginExists($login) {
    $login = mysqli_real_escape_string(getConnection(), $login);
    $login_res = mysqli_query(getConnection(), "select * from user where username = '".$login."';");
    if(mysqli_num_rows($login_res) > 0)
        return true;
    else return false;
}

function isPersonTeacher($pr_id) {
    $teacher_q = mysqli_query(getConnection(), "select * from teacher where t_id = ".$pr_id.";");
    if(mysqli_num_rows($teacher_q) > 0)
        return true;
    else return false;
}

function isPersonStudent($pr_id) {
    $student_q = mysqli_query(getConnection(), "select * from student where st_id = ".$pr_id.";");
    if(mysqli_num_rows($student_q) > 0)
        return true;
    else return false;
}

function isPersonParent($pr_id) {
    $parent_q = mysqli_query(getConnection(), "select * from parent where parent_id = ".$pr_id.";");
    if(mysqli_num_rows($parent_q) > 0)
        return true;
    else return false;
}

function ustawRole($us_id, $pr_id) {
    if(isPersonTeacher($pr_id)) {
        mysqli_query(getConnection(), "insert into user_role(us_id, role_id) values
		({$us_id}, 2);");
    }
    if(isPersonStudent($pr_id)) {
        mysqli_query(getConnection(), "insert into user_role(us_id, role_id) values
		({$us_id}, 3);");
    }
    if(isPersonParent($pr_id)) {
        mysqli_query(getConnection(), "insert into user_role(us_id, role_id) values
		({$us_id}, 4);");
    }
}

function getParentChildren($pr_id) {
    $parChildren = mysqli_query(getConnection(), "select parent_id as par_id,
     par_name, par_surname, st_id, st_name, st_surname from v_parent_student
     where parent_id = "
    .$pr_id);
    return $parChildren;
}



?>