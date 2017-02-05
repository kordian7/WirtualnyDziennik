<?php
include_once "../login_utils.php";
include_once "../protected/menu.php";
include_once "../school_db_utils.php";

if(isset($_GET['print']) && $_GET['print'] == true) {
    printTable();
}

function printTable() {
    if(isset($_GET['course_id'])) {
        $cour = mysqli_escape_string(getConnection(), $_GET['course_id']);
        $courses = getTeacherActiveCourses(getPersonId(getUserId()));
        $cr_ok = false;

        while ($cr = mysqli_fetch_assoc($courses)) {
            if ($cour== $cr['cour_id']) {
                $cr_name = $cr['course_name'];
                $cr_ok = true;
                break;
            }
        }
        if($cr_ok) {
            $exams = getCourseExams($cour);
            $students = getCourseStudents($cour);
            echo "
    <table class='table'>
    <tr> <th>Student \ Egzamin</th>";
            $ex_cnt = 0;
            while ($exam = mysqli_fetch_assoc($exams)) {
                echo "<th> " . $exam['nazwa'] . " </th> ";
                $ex_tab[$ex_cnt++] = $exam['ex_id'];
            }

            echo "<th><form action='add_exam.php' method=POST> <input hidden name='course' value = " . $cour . "> <button class=\"btn btn-primary btn-sm\" type='submit' value='Dodaj Exam'> <span class=\"glyphicon glyphicon-plus\" /></button></form></th></tr>";
            while ($stud = mysqli_fetch_assoc($students)) {
                echo "<tr><td> " . $stud['name'] . " " . $stud['surname'] . " </td>";
                for ($i = 0; $i < $ex_cnt; $i++) {
                    echo "<td>" . getMark($ex_tab[$i], $stud['st_id']) . "</td>";
                }
                echo "</tr> ";
            }
            echo "<tr><td/>";
            for ($i = 0; $i < $ex_cnt; $i++) {
                echo "<td><form action='edit_marks.php' method=POST> <input hidden name='exam' value = " . $ex_tab[$i] . "> <input class=\"btn btn-primary btn-sm\" type='submit' value='Edytuj'> </form>";
                echo "<br/><form action='remove_exam.php' method=POST> <input hidden name='exam' value = " . $ex_tab[$i] . "> <input class=\"btn btn-primary btn-sm\" type='submit' value='Usuń'> </form></td>";
            }
            echo "</tr>";
            echo "</table>";
        }
    } else {
        header("Location: add_marks.php");
        exit;
    }
}


?>