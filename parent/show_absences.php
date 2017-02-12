<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include_once "../login_utils.php";
include_once "../protected/menu.php";
include_once "../school_db_utils.php";
include_once "course_list.php";
include_once "student_absences.php";

createHead();
if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}
if(!checkUserRole(getUserRole())) {
    header("Location: ".getIndexPath(getUserRole()));
}
$parChildren = getParentChildren(getPersonId(getUserId()));
if(mysqli_num_rows($parChildren) == 0) {
        header("Location: ".getIndexPath(getUserRole()));
        }
createMenu(); ?>
<br>
<div class='main'>
    <input type="hidden" id="hidden-st-id" value="<?php
            if(mysqli_num_rows($parChildren) == 1) {
                $child = mysqli_fetch_assoc($parChildren);
                $childId = $child['st_id'];
                echo $childId;
            }
        ?>" >
    <div class="div-h-centered" style="max-width: 800px; width: 90%">
        <div style="text-align: center; font-size: 20px; padding-top: 20px; padding-bottom: 20px">
            <h1>
                Sprawdź Nieobecności
            </h1>
        </div>
    <?php
    $childId = null;
    if(mysqli_num_rows($parChildren) == 1) {
        echo "<h1 style='font-size: 18px;'>Twoje dziecko: <br>".$child['st_name']." ".$child['st_surname']." </h1>";
    } elseif(mysqli_num_rows($parChildren) > 1) {
        echo "Wybierz dziecko, którego nieobecności chcesz obejrzeć: <br>
    <select id='select-student' class='chosen-select' data-placeholder='Wybierz ucznia: ' id='id-studenta' >
        <br>
        <option> </option>";

        while($child = mysqli_fetch_assoc($parChildren)) {
            echo "
                    <br>
                    <option value={$child['st_id']}  > {$child['st_name']} {$child['st_surname']}</option>
                ";
        }
        echo "</select>";
    }

    ?>

        <div id="student-tab-containter" style="padding-top: 20px">
            <?php
            if(mysqli_num_rows($parChildren) == 1) {
                printStudentAbsences($child['st_id']);
            }
            ?>
        </div>

    </div>

</div>
<?php createFooter(); ?>

<script type="text/javascript">
    <?php
    if(mysqli_num_rows($parChildren) > 1) {
        echo "
        var \$select1 = $('#select-student');
        
        

        \$select1.on({
        'change' : function() {
            var selectVal = $(this).find('option:selected').val();
            if(selectVal != -1) {
                console.log( selectVal);
                $.ajax({
                    type: \"POST\",
                    url: \"/~kokurd/parent/student_absences.php\",
                    data: {
                    st_id: selectVal
                    },
                    success: function(tabela) {
                    console.log( \"Otrzymane dane: \" + tabela );
                    $('#student-tab-containter').empty();
                    $('#student-tab-containter').append(tabela);

                },
                    error: function() {
                    console.log( \"Błąd połączenia\");
                }
                })

            }
        }
    });

    \$select1.val(-1);
    ";

    }


    ?>




</script>

</body>
</html>