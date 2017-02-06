<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include_once "../login_utils.php";
include_once "../protected/menu.php";
include_once "../school_db_utils.php";
include_once "course_absences.php";

createHead();
if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}
if(!checkUserRole(getUserRole())) {
    header("Location: ".getIndexPath(getUserRole()));
}
createMenu(); ?>

<div class='main'>

    <div class="div-h-centered" style="max-width: 800px; width: 90%">
        <div style="text-align: center; font-size: 20px; padding-top: 20px; padding-bottom: 20px">
            <h1>
                Sprawdź nieobecności
            </h1>
        </div>

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

        <div id="absences-tab-containter" style="padding-top: 20px">

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
            console.log( "Wysyłam: " + selectVal  );
            $.ajax({
                type: "POST",
                url: "/~kokurd/teacher/course_absences.php",
                data: {
                    cour_id: selectVal
                },
                success: function(tabela) {
                    console.log( "Otrzymane dane: " + tabela );
                    $('#absences-tab-containter').empty();
                    $('#absences-tab-containter').append(tabela);

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