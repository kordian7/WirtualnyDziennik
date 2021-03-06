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
if(!isset($_POST['exam']) && !isset($_POST['exam-id'])) {
    header("Location: /~kokurd/teacher/add_marks.php");
}
// Zapis ocen do bazy
if(isset($_POST['exam-id'])) {
    mysqli_autocommit(getConnection(), false);
    mysqli_query(getConnection(),"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ");
    $examInfo = mysqli_fetch_assoc(getExamInfo($_POST['exam-id']));
    $oldExamName = $examInfo['nazwa'];
    $oldExamComment = $examInfo['comment'];
    $students = getCourseStudents($examInfo['cour_id']);
    $teacher_id = getPersonId(getUserId());
    if($_POST['exam-name'] != $oldExamName) {
        mysqli_query(getConnection(), "update exam set nazwa = '"
            .$_POST['exam-name']."' where ex_id="
            .$_POST['exam-id']);
    }
    $_POST['exam-comment'] = mysqli_escape_string(getConnection(), $_POST['exam-comment']);
    $_POST['exam-comment'] = strip_tags($_POST['exam-comment']);
    if($_POST['exam-comment'] != null && $_POST['exam-comment'] != $oldExamComment) {
        mysqli_query(getConnection(), "update exam set comment = '"
            .$_POST['exam-comment']."' where ex_id="
            .$_POST['exam-id']);
    }


    while($st=mysqli_fetch_assoc($students)) {
        if($_POST['st-'.$st['st_id']] != null) {
            $comment = "";
            $_POST['st-com-'.$st['st_id']] = mysqli_escape_string(getConnection(), $_POST['st-com-'.$st['st_id']]);
            $_POST['st-com-'.$st['st_id']] = strip_tags($_POST['st-com-'.$st['st_id']]);
            if($_POST['st-com-'.$st['st_id']] != null) {
                $comment = $_POST['st-com-'.$st['st_id']];
            }

            if (getMark($_POST['exam-id'], $st['st_id']) == null) {

                mysqli_query(getConnection(), "insert into exam_result(ex_id, t_id, st_id, mark, comment)
            values("
                    . $_POST['exam-id'] . ", "
                    . $teacher_id . ", "
                    . $st['st_id'] . ", '"
                    . $_POST['st-' . $st['st_id']] . "', '"
                    . $comment."')");
            } else {
                if(getMark($_POST['exam-id'], $st['st_id']) != $_POST['st-'.$st['st_id']]) {
                    mysqli_query(getConnection(), "update exam_result set mark = '"
                        . $_POST['st-' . $st['st_id']] . "' where ex_id = "
                        . $_POST['exam-id'] ." and st_id = "
                        . $st['st_id']);
                }
                if(getExamComment($_POST['exam-id'], $st['st_id']) != $_POST['st-com-'.$st['st_id']]) {
                    mysqli_query(getConnection(), "update exam_result set comment = '"
                        . $comment . "' where ex_id = "
                        . $_POST['exam-id'] ." and st_id = "
                        . $st['st_id']);
                }
            }

        } elseif (getMark($_POST['exam-id'], $st['st_id']) != null) {
            mysqli_query(getConnection(), "delete from exam_result where ex_id = "
                . $_POST['exam-id'] ." and st_id = "
                . $st['st_id']);
        }
    }
    mysqli_commit(getConnection());
    header("Location: /~kokurd/teacher/add_marks.php?course_id=".$examInfo['cour_id']."&ed_sc=true");
    exit;
}
createMenu();
$examInfo = mysqli_fetch_assoc(getExamInfo($_POST['exam']));
$oldExamName = $examInfo['nazwa'];
$students = getCourseStudents($examInfo['cour_id']);
$examInfo = mysqli_fetch_assoc(getExamInfo($_POST['exam']));
?>
<br>
<div class='main'>
    <div class="div-h-centered" style="width: 520px">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 28px">Edytuj oceny</h1>
        </div>
<form method="post" action="edit_marks.php">
<table class="table">
    <input type="hidden" name='exam-id' value=<?php echo $_POST['exam']; ?>>
    <tr><td>Nazwa</td>
        <td colspan="2"><input class="form-control" type="text" required="true" name="exam-name" value='<?php echo $examInfo['nazwa']; ?>' ></td></tr>
    <tr><td>Komentarz</td>
        <td colspan="2"><input class="form-control" type="text" name="exam-comment"  value='<?php echo $examInfo['comment']; ?>'></td></tr>
    <th>Uczeń</th><th>Ocena</th><th>Komentarz</th>
    <?php
        while($st=mysqli_fetch_assoc($students)) {
            echo "<tr><td>".$st['name']." ".$st['surname']."</td><td>
            <select class=\"selectpicker show-tick\" title=\"Brak\" data-width=\"fit\" name='st-".$st['st_id']."' 
            >
                  ".getMarksOptions(getMark($_POST['exam'],$st['st_id']))."
            </select></td>
            <td>
                <input type='text' class=\"form-control\" name='st-com-".$st['st_id']."' 
                    value='".getExamComment($_POST['exam'],$st['st_id'])."'>
            </td>
            </tr>";
            
           /*
            <input type='text' name='st-".$st['st_id']."' value='"
            .getMark($_POST['exam'],$st['st_id'])."'></td></tr>";*/
        }
        ?>

        <tr><td colspan="3">
                <input style=" float: right;" class="btn btn-primary btn-sm" type="submit" value="Zapisz egzamin">
                <a style="float: right; margin-right: 20px;" class="btn btn-primary btn-sm" href="/~kokurd/teacher/add_marks.php?course_id=<?php
                $examInfo = mysqli_fetch_assoc(getExamInfo($_POST['exam']));
                echo $examInfo['cour_id']; ?>">Anuluj</a>
     </td></tr>
</table>
</form>
    </div>
</div>
<?php createFooter(); ?>
</body>
</html>