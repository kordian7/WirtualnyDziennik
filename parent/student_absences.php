
<?php
include_once "../login_utils.php";
include_once "../protected/menu.php";
include_once "../school_db_utils.php";

if(isset($_POST['st_id'])) {
    $st_id = mysqli_escape_string(getConnection(), $_POST['st_id']);
    printStudentAbsences($st_id);
}

function printStudentAbsences($st_id) {
    echo "
        <table class='table table-striped' style=\"text-align: center\">
                <tr >
                    <th style=\"text-align: center\">Data</th>
                    <th style=\"text-align: center\">Przedmiot</th>
                    <th style=\"text-align: center\">Rodzaj nieobecności</th>
                    <th style=\"text-align: center\">Komentarz</th>
                </tr>";
                $absences = getStudentAbsences($st_id);
                if (mysqli_num_rows($absences) == 0) {
                    echo "
                    <tr>
                        <td>-</td><td>-</td><td>-</td><td>-</td>
                    </tr>
                    ";
                } else {
                    while ($ab = mysqli_fetch_assoc($absences)) {
                        echo "
                        <tr>
                            <td>" . $ab['absence_date'] . "</td><td>" . $ab['course_name'] . "</td><td>" . $ab['type'] . "</td><td>" . $ab['comment'] . "</td>
                        </tr>
                        ";
                    }
                }

        echo "</table>";
}
?>