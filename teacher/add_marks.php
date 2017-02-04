<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";
include_once "../school_db_utils.php";

createHead();
if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}
if(!checkUserRole(getUserRole())) {
    header("Location: ".getIndexPath(getUserRole()));
}
createMenu(); ?>
<br>
<div class='main'>
Lista prowadzonych kursów przez Ciebie:
<br>

    Osoba: <select class="chosen-select" data-placeholder="Wybierz kurs: " id="id-kursu" >
            <br>
            <option> </option>

    <?php
    $courses = getTeacherActiveCourses(getPersonId(getUserId()));
    while($cr = mysqli_fetch_assoc($courses)) {
        echo "
                    <br>
                    <option value={$cr['cour_id']}  > {$cr['classes']}  {$cr['course_name']} </option>
                ";
    }
    echo "</select>";
    // TODO
    $cour = 5;
    $exams = getCourseExams(5);
    $students = getCourseStudents(5);
    echo "<br>
    <table>
    <tr> <th>Student</th>";
    $ex_cnt = 0;
    while($exam = mysqli_fetch_assoc($exams)){
        echo "<th> ".$exam['nazwa']." </th> ";
        $ex_tab[$ex_cnt++] = $exam['ex_id'];
    }

    echo "<th><form action='add_exam.php' method=POST> <input hidden name='course' value = ".$cour."> <input type='submit' value='Dodaj Exam'> </form></th></tr>";
    while($stud = mysqli_fetch_assoc($students)){
        echo "<tr><td> ".$stud['name']." ".$stud['surname']." </td>";
            for($i=0; $i<$ex_cnt; $i++) {
                echo "<td>".getMark($ex_tab[$i],$stud['st_id'])."</td>";
            }
        echo "</tr> ";
    }
    echo "<td/>";
    for($i=0; $i<$ex_cnt; $i++) {
        echo "<td><form action='edit_marks.php' method=POST> <input hidden name='exam' value = ".$ex_tab[$i]."> <input type='submit' value='Edytuj'> </form></td>";
    }
    echo "</table>";
?>

</div>
<?php createFooter(); ?>
</body>
</html>