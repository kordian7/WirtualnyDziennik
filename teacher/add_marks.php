<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";
include_once "../school_db_utils.php";
include_once "teacher_course.php";

createHead();
if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}
if(!checkUserRole(getUserRole())) {
    header("Location: ".getIndexPath(getUserRole()));
}
if(isset($_GET['course_id'])) {
    $_GET['course_id'] =  mysqli_escape_string(getConnection(),$_GET['course_id']);

    $courses = getTeacherActiveCourses(getPersonId(getUserId()));
    $isCrOk = false;
    while($cr = mysqli_fetch_assoc($courses)) {
        if($cr['cour_id'] == $_GET['course_id']) {
            $isCrOk = true;
            break;
        }
    }
    if(!$isCrOk) {
        header("Location: /~kokurd/teacher/add_marks.php?q=f");
        exit;
    }
}


createMenu(); ?>

<br>
<div class='main'>
Lista prowadzonych kursów przez Ciebie:
<br>

    Osoba: <select id="select-course" class="chosen-select" data-placeholder="Wybierz kurs: " id="id-kursu" >
            <br>
            <option> </option>

    <?php
    $courses = getTeacherActiveCourses(getPersonId(getUserId()));
    while($cr = mysqli_fetch_assoc($courses)) {
        echo "
                    <br>
                    <option value={$cr['cour_id']}  > {$cr['classes']}  {$cr['course_name']} </option>
                ";
    }
    echo "</select>"; ?>
    <div id="teacher-course-tab-containter">
        <?php
        if(isset($_GET['course_id'])) {
            $cour = mysqli_escape_string(getConnection(), $_GET['course_id']);
            $exams = getCourseExams($cour);
            $students = getCourseStudents($cour);
            printTable();

        }
        ?>

    </div>



</div>
<?php createFooter(); ?>

<script type="text/javascript">

var $select1 = $('#select-course');

$select1.on({
    'change' : function() {
        var selectVal = $(this).find('option:selected').val();
        if(selectVal != -1) {
            console.log( "test");
            $.ajax({
                type: "GET",
                url: "/~kokurd/teacher/teacher_course.php",
                data: {
                    course_id: selectVal,
                    print: true
                },
                success: function(tabela) {
                    console.log( "Otrzymane dane: " + tabela );
                    $('#teacher-course-tab-containter').empty();
                    $('#teacher-course-tab-containter').append(tabela);

                },
                error: function() {
                    console.log( "Błąd połączenia");
                }
            })

        }
        }
    });

$select1.val(<?php
    if(isset($_GET['course_id']))
        echo $_GET['course_id'];
    else echo -1;
    ?>);



</script>
</body>
</html>