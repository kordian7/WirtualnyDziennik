<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include_once "../login_utils.php";
include_once "../protected/menu.php";
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
    <div class="div-h-centered" style="max-width: 800px; width: 90%">
        <div style="font-size: 20px;  padding-bottom: 20px">
            <h1>
                Nieobecności
            </h1>
        </div>


        <div id="student-absences-tab-containter" style="padding-top: 20px">
            <table class='table table-striped' style="text-align: center">
                <tr >
                    <th style="text-align: center">Data</th>
                    <th style="text-align: center">Przedmiot</th>
                    <th style="text-align: center">Rodzaj nieobecności</th>
                    <th style="text-align: center">Komentarz</th>
                </tr>
                <?php
                $absences = getStudentAbsences(getPersonId(getUserId()));
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
                ?>
                </table>
        </div>

        </div>
</div>
<?php createFooter(); ?>



</body>
</html>