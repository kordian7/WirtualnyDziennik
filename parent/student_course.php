<?php
include "../login_utils.php";
include "../protected/menu.php";
include_once "../school_db_utils.php";

if(isset($_POST['cour_id']) && $_POST['cour_id']!=null
    && isset($_POST['st_id']) && $_POST['st_id']!=null ) {
    $cr_id = mysqli_escape_string(getConnection(), $_POST['cour_id']);
    $st_id = mysqli_escape_string(getConnection(), $_POST['st_id']);
    $person = getPersonInfo($st_id);
    $course = getCourseInfo($cr_id);



    echo "<div class='prnt-course-info'>
            ".$person['name']." ".$person['surname']. " - ".$course['course_name']."
        </div>
    
    ";

        echo "
        <table class='table table-striped'>
        <tr>
            <th>Nazwa</th>
            <th>Ocena</th>
            <th>Komentarz</th>
        </tr>";

        $marks = getStudentMarksFromCourse($st_id, $cr_id);
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
} else {
    header("Location:show_courses.php");
    exit;
}
?>

