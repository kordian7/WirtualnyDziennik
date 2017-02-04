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
Lista Twoich obecnych przedmiotów:
<br>
<table>
    <th>
        <td>Nazwa przedmiotu</td>
    </th>
    <?php
    $courses = getStudentActiveCourses(getPersonId(getUserId()));
    while($cr = mysqli_fetch_assoc($courses)) {
    echo "
    <tr>
    <td><a href='show_marks.php?cr_id=".$cr['course_id']."'>".$cr['course_name']."</a></td>
    </tr>
    ";
    }

    ?>
</table>


</div>
<?php createFooter(); ?>
</body>
</html>