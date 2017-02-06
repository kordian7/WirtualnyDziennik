
<?php
include_once "../login_utils.php";
include_once "../protected/menu.php";
include_once "../school_db_utils.php";

if(isset($_POST['cour_id'])) {
    $cour_id = mysqli_escape_string(getConnection(), $_POST['cour_id']);
    printStudentAbsences($cour_id);
}

function printStudentAbsences($cour_id) {
    echo "
        <table class='table table-striped' style=\"text-align: center\">
                <tr >
                    <th style=\"text-align: center\">Data</th>
                    <th style=\"text-align: center\">Uczeń</th>
                    <th style=\"text-align: center\">Rodzaj nieobecności</th>
                    <th style=\"text-align: center\">Komentarz</th>
                </tr>";
                $absences = getCourseAbsences($cour_id);
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
                            <td>" . $ab['absence_date'] . "</td><td>" . $ab['name'] . " " . $ab['surname'] . " " . $ab['pesel'] . "</td>
                            <td> ".$ab['type']."</td><td>". $ab['comment']."</td>
                        </tr>
                        ";
                    }
                }

        echo "</table>";
}
?>