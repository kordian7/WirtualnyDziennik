<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";
include_once "../school_db_utils.php";


if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}
if(!checkUserRole(getUserRole())) {
    header("Location: ".getIndexPath(getUserRole()));
}
if(isset($_POST['course-id']) && isset($_POST['student-id']) && isset($_POST['abs-id-type']) && isset($_POST['data-abs'])) {
    foreach ($_POST as $key=>$value) {
        $_POST[$key] = mysqli_real_escape_string(getConnection(), $value);
    }
    $_POST['comment'] = strip_tags($_POST['comment']);
    mysqli_autocommit(getConnection(), false);
    $courses = getTeacherActiveCourses(getPersonId(getUserId()));
    $isCrOk = false;
    while($cr = mysqli_fetch_assoc($courses)) {
        if($cr['cour_id'] == $_POST['course-id']) {
            $isCrOk = true;
            break;
        }
    }
    if(!$isCrOk) {
        header("Location: /~kokurd/teacher/add_absence.php?q=f");
        exit;
    }
    $comment ="";
    if(isset($_POST['comment']) && $_POST['comment'] != null) {
        $comment = $_POST['comment'];
    }
    mysqli_query(getConnection(), "insert into absence(st_id, cour_id, absence_date, abt_id, comment) 
    values(".
        $_POST['student-id'].", ".
        $_POST['course-id'].", STR_TO_DATE('".
        $_POST['data-abs']."', '%Y-%m-%d'), ".
        $_POST['abs-id-type'].", '".
        $comment."')");
    if(mysqli_errno(getConnection())) {
        mysqli_rollback(getConnection());
        header("Location: /~kokurd/teacher/add_absence.php?success=false");
        exit;
    } else {
        mysqli_commit(getConnection());
        header("Location: /~kokurd/teacher/add_absence.php?success=true");
        exit;
    }
    
}

createHead();
createMenu(); ?>

<br>
<div class='main'>
    <?php
    if(isset($_GET['success']) && $_GET['success'] == 'true' ) {
        echo "
            <div class=\"alert alert-success alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Sukces</strong> Dodano nieobecność
            </div>

        ";
    }
    if(isset($_GET['success']) && $_GET['success'] == 'false' ) {
        echo "
            <div class=\"alert alert-danger alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Error</strong> Wystąpił problem z dodaniem nieobecności
            </div>

        ";
    }
    ?>


    <div class="div-h-centered" style="width: 500px">
        <div style="text-align: center; font-size: 28px; ">
            <h1 style="font-size: 20px; ">
                Dodawanie nieobecności
            </h1>
        </div>

        <form  class="form-horizontal" action="add_absence.php" method=POST>
            <div class="form-group">
                <label for="id-kursu" class="col-sm-3 control-label">Przedmiot:</label>
                <div class="col-sm-9">
                    <select id="select-course" name="course-id" class="chosen-select" data-placeholder="Wybierz kurs: " required="true">
                        <option> </option>
                    <?php
                    $courses = getTeacherActiveCourses(getPersonId(getUserId()));
                    while($cr = mysqli_fetch_assoc($courses)) {
                        echo "
                    <br>
                    <option value={$cr['cour_id']}  > {$cr['classes']}  {$cr['course_name']} </option>";
                    } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="select-student" class="col-sm-3 control-label">Uczeń:</label>
                <div class="col-sm-9">
                    <select id="select-student" name="student-id" class="chosen-select" data-placeholder="Wybierz ucznia: "  required="true">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="select-abs-type" class="col-sm-3 control-label">Typ absencji:</label>
                <div class="col-sm-9">
                    <select id="select-abs-type" name="abs-id-type" class="chosen-select" data-placeholder="Typ absencji: " required="true">
                        <option></option>
                        <?php
                        $absences = getAbsenceTypes();
                        while($abs = mysqli_fetch_assoc($absences)) {
                            echo "<option value={$abs['ab_id']}  > {$abs['type']} </option>";
                        }

                        ?>

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputDate" class="col-sm-3 control-label">Data absencji:</label>
                <div class="col-sm-9">
                    <input class="form-control"  type="date" name="data-abs" id="inputDate"  required="true">
                </div>
            </div>
            <div  class="form-group">
                <label for="inputComment" class="col-sm-3 control-label">Komentarz:</label>
                <div class="col-sm-9">
                    <input class="form-control"  type=text name="comment" id="inputComment" placeholder="Komentarz" >
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <input class="btn btn-primary btn-sm" type=submit value="Dodaj nieobecność">
                </div>
            </div>
        </form>



    </div>
    </div>

<?php createFooter(); ?>



<script type="text/javascript">

var $select1 = $('#select-course');
var $select2 = $('#select-student');

$select1.on({
    'change' : function() {
        var selectVal = $(this).find('option:selected').val();
        if(selectVal != -1) {
            console.log( "Wysyłam: " + selectVal  );
            $.ajax({
                type: "POST",
                url: "/~kokurd/teacher/course_student_list.php",
                data: {
                    cr_id: selectVal
                },
                success: function(tabela) {
                    console.log( "Otrzymane dane: " + tabela );
                    $select2.prop('disabled', 0);
                    $select2.empty();
                    $select2.append(tabela);
                    $select2.trigger("chosen:updated");

                },
                error: function() {
                    console.log( "Błąd połączenia");
                }
            })

        }
        }
    });

$select1.val(-1);
$select2.prop('disabled', 1);

$(function() {
    $( "#inputDate" ).datepicker({ dateFormat: 'yy-mm-dd', maxDate: 0});
});


</script>
</body>
</html>