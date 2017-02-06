<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include_once "../login_utils.php";
include_once "../protected/menu.php";
include_once "../school_db_utils.php";
include_once "course_list.php";

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
    <div class="div-centered" style="padding-right: 30px; top: 28%; width: 800px">
        <div style="text-align: center; font-size: 20px; padding-top: 20px; padding-bottom: 20px">
            <h1>
                Sprawdź oceny
            </h1>
        </div>
<table class="table">
    <tr>
        <td>
    <?php
    $childId = null;
    if(mysqli_num_rows($parChildren) == 1) {
        echo "Twoje dziecko: <br>".$child['st_name']." ".$child['st_surname'];
    } elseif(mysqli_num_rows($parChildren) > 1) {
        echo "Wybierz dziecko, którego oceny chcesz obejrzeć: <br>
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
        </td><td>
Lista przedmiotów:
<br>


    Przedmiot: <select id="select-course" class="chosen-select" data-placeholder="Wybierz kurs: " id="id-kursu" >
                <?php
                if(mysqli_num_rows($parChildren) == 1) {
                    printCourseList($child['st_id']);
                }
                ?>

        </select>
        </td>
    </tr>
</table>
    </div>
        <div id="student-tab-containter" style="padding-top: 250px">

        </div>
</div>
<?php createFooter(); ?>

<script type="text/javascript">
    var $select2 = $('#select-course');
    <?php
    if(mysqli_num_rows($parChildren) > 1) {
        echo "
        var \$select1 = $('#select-student');
        
        

        \$select1.on({
        'change' : function() {
            var selectVal = $(this).find('option:selected').val();
            var hidden1 = $('#hidden-st-id');
            hidden1.val(selectVal);
            console.log(hidden1.val());
            if(selectVal != -1) {
                console.log( \"test\");
                $.ajax({
                    type: \"POST\",
                    url: \"/~kokurd/parent/course_list.php\",
                    data: {
                    st_id: selectVal
                    },
                    success: function(tabela) {
                    console.log( \"Otrzymane dane: \" + tabela );
                    \$select2.prop('disabled', 0);
                    $('#select-course').empty();
                    $('#select-course').append(tabela);
                    $('#select-course').trigger(\"chosen:updated\");

                },
                    error: function() {
                    console.log( \"Błąd połączenia\");
                }
                })

            }
        }
    });

    \$select1.val(-1);
    \$select2.prop('disabled', 1);
    ";

    }


    ?>

    $select2.on({
        'change' : function() {
            var selectVal2 = $(this).find('option:selected').val();
            if(selectVal2 != -1) {
                $.ajax({
                    type: "POST",
                    url: "/~kokurd/parent/student_course.php",
                    data: {
                        cour_id: selectVal2,
                        st_id: $('#hidden-st-id').val()

                    },
                    success: function(tabela) {
                        console.log( "Otrzymane dane: " + tabela );
                        $('#student-tab-containter').empty();
                        $('#student-tab-containter').append(tabela);

                    },
                    error: function() {
                        console.log( "Błąd połączenia");
                    }
                })

            }
        }
    });



</script>

</body>
</html>