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

function getTeacherActiveCourses($t_id) {
    $st_cours = mysqli_query(getConnection(),
        "select cour_id, course_name, c_year, classes from v_teacher_course WHERE t_id = "
        .$t_id." and c_year = "
        .getCurrentSchoolYear());
    return $st_cours;
}

function getCourseStudents($c_id) {
    $st = mysqli_query(getConnection(),
        "select st_id, name, surname, pesel from v_student_course WHERE course_id =".
        $c_id);
    return $st;
}

function getCourseExams($c_id) {
     $ex = mysqli_query(getConnection(),
         "select ex_id, nazwa from exam WHERE cour_id =".
         $c_id);
    return $ex;
}

function getMark($ex_id, $st_id) {
    $res = mysqli_fetch_assoc(mysqli_query(getConnection(),
        "select mark as mark_id from exam_result where ex_id="
    .$ex_id." and st_id="
    .$st_id));
    return $res['mark_id'];
}

function getExamComment($ex_id, $st_id) {
    $res = mysqli_fetch_assoc(mysqli_query(getConnection(),
        "select comment from exam_result where ex_id="
        .$ex_id." and st_id="
        .$st_id));
    return $res['comment'];
}

function getExamInfo($ex_id) {
     $res = mysqli_query(getConnection(),
         "select ex_id, cour_id, ex_type_id, nazwa, comment from exam where ex_id="
         .$ex_id);
     return $res;
}

function getCourseInfo($cr_id) {
     $qr = mysqli_query(getConnection(), "select cour_id, year, course_name
        from v_course where cour_id = "
        .$cr_id);
    return mysqli_fetch_assoc($qr);
}

function getAbsenceTypes() {
    $ex = mysqli_query(getConnection(),
        "select ab_id, type from absence_type");
    return $ex;
}

function getStudentAbsences($st_id) {
     $st_abs = mysqli_query(getConnection(), "select st_id, name, surname, pesel,
     cour_id, course_name, type, absence_date, comment from v_absence where st_id="
    .$st_id);
     return $st_abs;
}

function getCourseAbsences($cour_id) {
    $cour_abs = mysqli_query(getConnection(), "select st_id, name, surname, pesel,
     cour_id, course_name, type, absence_date, comment from v_absence where cour_id="
        .$cour_id);
    return $cour_abs;
}

function getActiveClasses() {
     $q = mysqli_query(getConnection(), "select class_id, section, year_started, year from class
     where active ='T'");
     return $q;
}

function getCourseTypes() {
    $q = mysqli_query(getConnection(), "select cour_tp_id, course_name from course_type");
    return $q;
}

function getCourseAvailStudents($cr_id) {

}

?>