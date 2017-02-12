<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";
include_once "../school_db_utils.php";

if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}
if(!checkUserRole(getUserRole())) {
    header("Location: ".getIndexPath(getUserRole()));
}
if(!isset($_POST['exam'])) {
    header("Location: /~kokurd/teacher/add_marks.php");
} else {
    $_POST['exam'] = mysqli_escape_string(getConnection(), $_POST['exam']);

    $examInfo = mysqli_fetch_assoc(getExamInfo($_POST['exam']));
    $ex_r_q = mysqli_query(getConnection(), "select * from exam_result where ex_id="
        . $_POST['exam']);
    if (mysqli_num_rows($ex_r_q ) > 0) {
        header("Location: /~kokurd/teacher/add_marks.php?course_id=" . $examInfo['cour_id'] . "&rm_sc=false");
        exit;
    } else {
        mysqli_query(getConnection(), "delete from exam where ex_id = "
            . $_POST['exam']);
        header("Location: /~kokurd/teacher/add_marks.php?course_id=" . $examInfo['cour_id'] . "&rm_sc=true");
        exit;
    }
}
header("Location: /~kokurd/teacher/add_marks.php");
exit;
?>