<?php
include "../login_utils.php";
include "../protected/menu.php";
include_once "../school_db_utils.php";

if(isset($_POST['cour_id']) && $_POST['cour_id']!=null) {
    $cr_id = mysqli_escape_string(getConnection(), $_POST['cour_id']);


    $courses = getStudentActiveCourses(getPersonId(getUserId()));
    $cr_ok = false;

    while ($cr = mysqli_fetch_assoc($courses)) {
        if ($cr_id == $cr['course_id']) {
            $cr_name = $cr['course_nacme'];
            $cr_ok = true;
            break;
        }
    }
    if ($cr_ok) {
        echo "
        <table class='table table-striped'>
        <tr>
            <th style='text-align: center'>Nazwa</th>
            <th style='text-align: center'>Ocena</th>
            <th style='text-align: center'>Komentarz</th>
        </tr>";

        $marks = getStudentMarksFromCourse(getPersonId(getUserId()), $cr_id);
        if (mysqli_num_rows($marks) == 0) {
            echo "
        <tr>
        <td>-</td><td>-</td><td>-</td>
        </tr>
        ";
        } else {
            while ($mr = mysqli_fetch_assoc($marks)) {
                echo "
                <tr>
                <td>" . $mr['nazwa'] . "</td><td>" . $mr['mark'] . "</td><td>" . $mr['comment'] . "</td>
                </tr>
                ";
            }
        }
        echo "</table>";
    }
} else {
    header("Location:show_courses.php");
    exit;
}
?>

