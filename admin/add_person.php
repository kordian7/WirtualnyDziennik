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

// TRANSAKCJA
if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['pesel']) && isset($_POST['mail'])) {

    foreach($_POST as $key=>$value) {
        if($key != 'children') {
            $_POST[$key] = mysqli_real_escape_string(getConnection(), $value);
            $_POST[$key] = strip_tags($_POST[$key]);
        }
    }
    if($_POST['name'] == null || $_POST['surname'] == null || $_POST['pesel'] ==null
    || $_POST['mail'] == null) {
        header("Location: add_person.php?success=bad_data");
        exit;
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
    try {
        mysqli_autocommit(getConnection(),false);
        mysqli_query(getConnection(),"SET TRANSACTION ISOLATION LEVEL REPEATABLE READ");
        if(!mysqli_query(getConnection(), "CALL proc_dodaj_osobe('"
            .$_POST['name']."', '"
            .$_POST['surname']."','"
            .$_POST['pesel']."', '"
            .$_POST['mail']."', '"
            .$_POST['phone-nr']."', '"
            .$is_teacher."', '"
            .$is_student."', '"
            .$is_parent."',@id);")) {
                if(mysqli_error(getConnection()) == 'PeselExists')
                    throw new Exception('PeselExists');
        }
        $id_res = mysqli_fetch_assoc(mysqli_query(getConnection(), "Select @id"));
        $id=$id_res['@id'];


        if($is_parent == 't'){

            if(isset($_POST['children'])){
                foreach($_POST['children'] as $child){

                    mysqli_query(getConnection(), "insert into parent_student(parent_id, student_id)
                values(".
                        $id.", ".
                        $child.")");
                }
            }
        }
    mysqli_commit(getConnection());
    } catch (Exception $e) {
        mysqli_rollback(getConnection());
        header("Location: add_person.php?success=false");
        exit;
    }

    header("Location: add_person.php?success=true");
    exit;
}
createMenu();
?>
<br>
<div class='main'>
<?php
    if(isset($_GET['success']) && $_GET['success'] == 'true' ) {
        echo "
            <div class=\"alert alert-success alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Sukces</strong> Dodano nową osobę
            </div>

        ";
    }
    if(isset($_GET['success']) && $_GET['success'] == 'false' ) {
        echo "
                <div class=\"alert alert-warning alert-dismissable\">
                <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                <strong>Warning</strong> Osoba z podanym peselem już istnieje
                </div>
    
            ";
    }
    if(isset($_GET['success']) && $_GET['success'] == 'bad_data' ) {
        echo "
                <div class=\"alert alert-danger alert-dismissable\">
                <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                <strong>Error</strong> Niepoprawne dane
                </div>
    
            ";
}

?>

    <div class="div-h-centered" style="width: 500px">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 28px">Dodawanie nowej osoby</h1>
        </div>
    <form class="form-horizontal" action="add_person.php" method=POST onsubmit="return validateForm()">
        <div class="form-group">
            <label for="inputName" class="col-sm-3 control-label">Imię:</label>
            <div class="col-sm-9">
                <input class="form-control" id="inputName" type=text name="name" placeholder="Imię"  required="true">
            </div>
        </div>
        <div class="form-group">
            <label for="inputSurname" class="col-sm-3 control-label">Nazwisko:</label>
            <div class="col-sm-9">
                <input class="form-control"  placeholder="Nazwisko" type=text required="true" name="surname" id="inputSurname" >
            </div>
        </div>
        <div id="pesel-div" class="form-group">
            <label for="pesel" class="col-sm-3 control-label">Pesel:</label>
            <div class="col-sm-9">
                <input class="form-control"  placeholder="Pesel" type=text name="pesel" id="pesel" maxlength="11" required="true" >
            </div>
        </div>
        <div class="form-group">
            <label for="inputMail" class="col-sm-3 control-label">Mail:</label>
            <div class="col-sm-9">
                <input class="form-control"  placeholder="Mail" type="email" name="mail" id="inputMail"  required="true" >
            </div>
        </div>
        <div id="phone-div" class="form-group">
            <label for="phone-nr" class="col-sm-3 control-label">Nr telefonu:</label>
            <div class="col-sm-9">
                <input class="form-control"  placeholder="Numer telefonu"  type=text maxlength="9" name="phone-nr" id="phone-nr" >
            </div>
        </div>
        <div class="form-group">
            <label for="inputTeacher" class="col-sm-3 control-label">Nauczyciel:</label>
            <div class="col-sm-9">
                <input class="form-control" id="inputTeacher"  type="checkbox" name="teacher" value="true" >
            </div>
        </div>
        <div class="form-group">
            <label for="inputStudent" class="col-sm-3 control-label">Uczeń:</label>
            <div class="col-sm-9">
                <input class="form-control" id="inputStudent"  type="checkbox" name="student" value="true" >
            </div>
        </div>
        <div class="form-group">
            <label for="parent" class="col-sm-3 control-label">Rodzic:</label>
            <div class="col-sm-9">
                <input class="form-control" type="checkbox" name="parent" id="parent" value="true" onchange="toggleChildren();">
            </div>
        </div>
        <div class="form-group" id="children-tr" style="display: none;">
            <label for="inputChildren" class="col-sm-3 control-label">Dziecko/dzieci:</label>
            <div class="col-sm-9">
                <select multiple="multiple" class="chosen-select" data-placeholder="Wybierz dzieci" name="children[]" >
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

            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <input class="btn btn-primary btn-sm" type=submit value="Dodaj osobe">
            </div>
        </div>





    </form>
    </div>
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
                document.getElementById("phone-div").className += " has-error";
                ret = false;
            } else {
                $('#phone-div').removeClass("has-error");
            }
        }
        if(!document.getElementById("pesel").value.match(peselPatt)) {
            document.getElementById("pesel-div").className += " has-error";
            ret = false;
        } else {
            $('#pesel-div').removeClass("has-error");
        }
        return ret;
    }

</script>
<?php createFooter(); ?>
</body>
</html>