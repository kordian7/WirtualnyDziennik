<?php
 include_once "baza.php";

 function getStudentActiveCourses($st_id) {
     $st_cours = mysqli_query(getConnection(),
         "select course_id, course_name from v_student_course WHERE st_id = "
        .$st_id." and course_y = "
        .getCurrentSchoolYear());
     return $st_cours;
 }

function getStudentMarksFromCourse($st_id, $cr_id) {
    $st_marks = mysqli_query(getConnection(),
    "select st_id, cour_id, nazwa, mark, comment from v_course_mark WHERE st_id = ".$st_id." and cour_id = ".$cr_id);
    return $st_marks;
}

?>