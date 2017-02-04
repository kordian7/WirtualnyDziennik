<?php
include "../login_utils.php";
include "../protected/menu.php";
include_once "../school_db_utils.php";

if(isset($_POST['cour_id'])) {
    $cour = mysqli_escape_string(getConnection(), $_POST['cour_id']);
    $exams = getCourseExams($cour);
    $students = getCourseStudents($cour);
    echo "
    <table>
    <tr> <th>Student</th>";
    $ex_cnt = 0;
    while ($exam = mysqli_fetch_assoc($exams)) {
        echo "<th> " . $exam['nazwa'] . " </th> ";
        $ex_tab[$ex_cnt++] = $exam['ex_id'];
    }

    echo "<th><form action='add_exam.php' method=POST> <input hidden name='course' value = " . $cour . "> <input type='submit' value='Dodaj Exam'> </form></th></tr>";
    while ($stud = mysqli_fetch_assoc($students)) {
        echo "<tr><td> " . $stud['name'] . " " . $stud['surname'] . " </td>";
        for ($i = 0; $i < $ex_cnt; $i++) {
            echo "<td>" . getMark($ex_tab[$i], $stud['st_id']) . "</td>";
        }
        echo "</tr> ";
    }
    echo "<td/>";
    for ($i = 0; $i < $ex_cnt; $i++) {
        echo "<td><form action='edit_marks.php' method=POST> <input hidden name='exam' value = " . $ex_tab[$i] . "> <input type='submit' value='Edytuj'> </form></td>";
    }
    echo "</table>";
}
?>