<?php
include_once "../login_utils.php";
include_once "../protected/menu.php";
include_once "../school_db_utils.php";

if(isset($_POST['st_id']) ) {
    $st_id = mysqli_escape_string(getConnection(), $_POST['st_id']);
    printCourseList($st_id);
}

function printCourseList($st_id) {
    echo " 
        <option></option>";

        $courses = getStudentActiveCourses($st_id);
        while($cr = mysqli_fetch_assoc($courses)) {
            echo "
                    <option value={$cr['course_id']}  > {$cr['course_name']} </option>
                ";
        }
}


?>