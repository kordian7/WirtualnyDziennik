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
if(!isset($_GET['cr_id']) || $_GET['cr_id']==null) {
    header("Location: /~kokurd/student/show_courses.php");
}
$cr_id = mysqli_escape_string(getConnection(), $_GET['cr_id']);

$courses = getStudentActiveCourses(getPersonId(getUserId()));
$cr_ok = false;

while($cr = mysqli_fetch_assoc($courses)) {
    if($cr_id == $cr['course_id']) {
        $cr_name = $cr['course_name'];
        $cr_ok = true;
        break;
    }
}
if(!$cr_ok) {
    header("Location: /~kokurd/student/show_courses.php");
}

createMenu();
?>
<br>
<div class='main'>
Oceny z przedmiotu: <?php echo $cr_name;?>
<br>
<table>
    <th>
        <td>Nazwa</td>
        <td>Ocena</td>
        <td>Komentarz</td>
    </th>
    <?php
    $marks = getStudentMarksFromCourse(getPersonId(getUserId()), $cr_id);
    if(mysqli_num_rows($marks) == 0) {
        echo "
    <tr>
    <td>Brak ocen</td><td>-</td><td>-</td>
    </tr>
    ";
    }
    else {
        while ($mr = mysqli_fetch_assoc($marks)) {
            echo "
            <tr>
            <td>" . $mr['nazwa'] . "</td><td>" . $mr['mark'] . "</td><td>" . $mr['comment'] . "</td>
            </tr>
            ";
        }
    }
    ?>
</table>


</div>
<?php createFooter(); ?>
</body>
</html>