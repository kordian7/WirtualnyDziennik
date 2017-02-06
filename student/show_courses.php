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
    <div class="div-h-centered" style="width: 800px">
        <div style="font-size: 20px;  padding-bottom: 20px">
            <h1>
                Sprawdź oceny
            </h1>
        </div>

    Osoba: <select id="select-course" class="chosen-select" data-placeholder="Wybierz kurs: " id="id-kursu" >
        <br>
        <option> </option>

        <?php
        $courses = getStudentActiveCourses(getPersonId(getUserId()));
        while($cr = mysqli_fetch_assoc($courses)) {
            echo "
                    <br>
                    <option value={$cr['course_id']}  > {$cr['course_name']} </option>
                ";
        } ?>
        </select>
        <div id="student-course-tab-containter" style="padding-top: 20px">

        </div>

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
                    type: "POST",
                    url: "/~kokurd/student/student_course.php",
                    data: {
                        cour_id: selectVal
                    },
                    success: function(tabela) {
                        console.log( "Otrzymane dane: " + tabela );
                        $('#student-course-tab-containter').empty();
                        $('#student-course-tab-containter').append(tabela);

                    },
                    error: function() {
                        console.log( "Błąd połączenia");
                    }
                })

            }
        }
    });

    $select1.val(-1);



</script>

</body>
</html>