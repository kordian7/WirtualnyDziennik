<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";

createHead();
if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}
if(!checkUserRole(getUserRole())) {
    header("Location: ".getIndexPath(getUserRole()));
}


createMenu();

// DODANIE UZYTKOWNIKA DO BAZY
// TRANSAKCJA

if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['pesel']) && isset($_POST['mail'])) {

    foreach($_POST as $key=>$value) {
        $_POST[$key] = mysqli_real_escape_string(getConnection(), $value);
    }
    $is_teacher = 'f';
    $is_student = 'f';
    $is_parent = 'f';
    if(isset($_POST['teacher']) && $_POST['teacher'] == 'true')
        $is_teacher = 't';
    if(isset($_POST['student']) && $_POST['student'] == 'true')
        $is_student = 't';
    if(isset($_POST['parent']) && $_POST['parent'] == 'true')
        $is_parent = 't';

    if(!mysqli_query(getConnection(), "CALL proc_dodaj_osobe('"
        .$_POST['name']."', '"
        .$_POST['surname']."','"
        .$_POST['pesel']."', '"
        .$_POST['mail']."', '"
        .$_POST['phone-nr']."', '"
        .$is_teacher."', '"
        .$is_student."', '"
        .$is_parent."',@id);")) {
        ;
    }
    $id_res = mysqli_fetch_assoc(mysqli_query(getConnection(), "Select @id"));
    $id=$id_res['@id'];

    // TODO - dodanie relacji student - rodzic

    header("Location: /~kokurd/admin/add_person.php?success=true&id=".$id);
    exit;


}












?>
<br>
<div class='main'>
<?php
    if(isset($_GET['success']) && $_GET['success'] == 'true' ) {
        echo "
            <div class='success'>
                Dodano nową osobę
            </div>
        ";
    }
?>

Dodawanie nowego użytkownika
    <form action="add_person.php" method=POST onsubmit="return validateForm()">
        <table class="form-table">

            <tr><td>
                    Imię: </td><td> <input type=text name="name"   required="true"> </td>
            </tr>
            <tr><td>
                    Nazwisko: </td><td> <input type=text name="surname" required="true">
            </tr>
            <tr><td>
                    Pesel: </td><td> <input type=text name="pesel" id="pesel" maxlength="11" required="true">
            </tr>
            <tr><td>
                    Mail: </td><td> <input type=text name="mail"   required="true">
            </tr>
            <tr><td>
                    Nr telefonu: </td><td> <input type=text maxlength="9" name="phone-nr" id="phone-nr" >
            </tr>


        <tr><td>
                    Nauczyciel: </td><td> <input  type="checkbox" name="teacher" value="true" > </td>
        </tr>
            <tr><td>
                    Uczeń: </td><td> <input  type="checkbox" name="student" value="true" > </td>
            </tr>
            <tr><td>
                    Rodzic: </td><td> <input  type="checkbox" name="parent" id="parent" value="true" onchange="toggleChildren();"> </td>
            </tr>
            <tr  id="children-tr" style="display: none;"><td>
                    Dziecko/dzieci: </td><td><select multiple class="chosen-select" data-placeholder="Wybierz dzieci" name="children" >
                        <br>
                        <option> </option>

                        <?php
                        $people = getStudents();
                        while($person = mysqli_fetch_assoc($people)) {
                            echo "
                    <br>
                    <option value={$person['st_id']}  > {$person['surname']}  {$person['name']} {$person['pesel']} </option>
                ";
                        }

                        ?>
                    </select>
                </td></tr>
        <tr><td colspan="2">
            <input  type=submit value="Dodaj osobe">
                </td></tr>
        </table>
    </form>

</div>
<script>
    $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
    });



    function toggleChildren() {
        console.log(document.getElementById("parent").value);
        if(document.getElementById("parent").checked) {
            document.getElementById("children-tr").style.display = "";
        } else {
            document.getElementById("children-tr").style.display = "none";
        }
    }

    function validateForm() {
        var nrPatt = /^\d{9}$/;
        var peselPatt = /^\d{11}$/;
        var ret = true;
        if(document.getElementById("phone-nr").value != "") {
            if(!document.getElementById("phone-nr").value.match(nrPatt)){
                ret = false;
            }
        }
        if(!document.getElementById("pesel").value.match(peselPatt)) {
            ret = false;
        }
        return ret;
    }



</script>
<?php createFooter(); ?>
</body>
</html>