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
if(!isset($_POST['course']) && !isset($_POST['exam-id'])) {
    header("Location: /~kokurd/teacher/add_marks.php");
}
// Zapis ocen do bazy
if(isset($_POST['exam-name']) && isset($_POST['course-id'])) {
    foreach ($_POST as $key=>$value) {
        $_POST[$key] = mysqli_real_escape_string($connection, $value);
    }
    // TRANSAKCJA???
    $students = getCourseStudents($_POST['course-id']);
    $teacher_id = getPersonId(getUserId());
    if(isset($_POST['exam-comment']) && $_POST['exam-comment'] != null) {
        mysqli_query(getConnection(), "insert into exam(cour_id, nazwa, comment) values("
            .$_POST['course-id'].", '"
            .$_POST['exam-name']."', '"
            .$_POST['exam-comment']."')");


    }  else {
        mysqli_query(getConnection(), "insert into exam(cour_id, nazwa) values("
            .$_POST['course-id'].", '"
            .$_POST['exam-name']."')");
    }
    $exam_id = mysqli_insert_id(getConnection());

    while($st=mysqli_fetch_assoc($students)) {
        if($_POST['st-'.$st['st_id']] != null) {
            $comment = "";
            if($_POST['st-com-'.$st['st_id']] != null) {
                $comment = $_POST['st-com-'.$st['st_id']];
            }

                mysqli_query(getConnection(), "insert into exam_result(ex_id, t_id, st_id, mark, comment)
            values("
                    . $exam_id . ", "
                    . $teacher_id . ", "
                    . $st['st_id'] . ", '"
                    . $_POST['st-' . $st['st_id']] . "', '"
                    . $comment."')");
        }
    }

    header("Location: /~kokurd/teacher/add_marks.php?course_id=".$_POST['course-id']);
    exit;
}
createMenu();
$students = getCourseStudents($_POST['course']);
?>
<br>
<div class='main'>
    Dodaj nowy egzamin:
    <br>
<form method="post" action="add_exam.php">
<table>
    <input type="hidden" name="course-id" value='<?php echo $_POST['course']; ?>'>
    <tr><td>Nazwa</td>
        <td colspan="2"><input type="text" required="true" name="exam-name"  ></td></tr>
    <tr><td>Komentarz</td>
        <td colspan="2"><input type="text" name="exam-comment"  ></td></tr>
        <th>Uczeń</th><th>Ocena</th><th>Komentarz</th>
    <?php
        while($st=mysqli_fetch_assoc($students)) {
            echo "<tr><td>".$st['name']." ".$st['surname']."</td><td>
            <select class=\"selectpicker show - tick\" title=\"Brak\" data-width=\"fit\" name='st-".$st['st_id']."'
            >
                  ".getNewMarksOptions()."
            </select></td>
            <td>
                <input type='text' name='st-com-".$st['st_id']."'>
            </td>
            </tr>";
        }
        ?>
    <tr><td colspan="2"> <a class="btn btn-primary btn-sm"  href="/~kokurd/teacher/add_marks.php?course_id=<?php
                echo $_POST['course']; ?>">Anuluj</a></td>
    </tr>
    <tr><td colspan="2"><input class="btn btn-primary btn-sm" type="submit" value="Dodaj egzamin"> </td></tr>
</table>
</form>

</div>
<?php createFooter(); ?>
</body>
</html>