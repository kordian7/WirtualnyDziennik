<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";

createHead();
if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}


mysqli_autocommit(getConnection(),FALSE);
$person = getPersonInfo(getPersonId(getUserId()));

if(isset($_POST['mail']) && $_POST['mail'] != null) {

    foreach($_POST as $key=>$value) {
        $_POST[$key] = mysqli_real_escape_string(getConnection(), $value);
    }

    if($_POST['mail'] != $person['mail']) {
        mysqli_query(getConnection(),"update person set mail = '"
            .$_POST['mail']
            ."' where pr_id = "
            .$person['pr_id']
            .";");
    }

    if(isset($_POST['phone-nr']) && $_POST['phone-nr'] != $person['phone_nr']) {
        mysqli_query(getConnection(),"update person set phone_nr = '"
            .$_POST['phone-nr']
            ."' where pr_id = "
            .$person['pr_id']
            .";");
    }

    mysqli_commit(getConnection());

    header("Location: /~kokurd/default/edytuj_dane.php?success=true");
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
            <strong>Sukces</strong> Dane zmienione
            </div>

        ";
    }
?>

    <div class="div-centered" style="width:500px; top:45%">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 28px">Edycja danych</h1>
        </div>


    <form class="form-horizontal" action="edytuj_dane.php" method=POST onsubmit="return validateForm()">
        <table class="form-table">
            <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">Imię:</label>
                <div class="col-sm-9">
                    <input class="form-control" id="inputName" type=text disabled value=<?php echo $person['name'];?>>
                </div>
            </div>
            <div class="form-group">
                <label for="inputSurname" class="col-sm-3 control-label">Nazwisko:</label>
                <div class="col-sm-9">
                    <input class="form-control" id="inputSurname" type=text disabled value=<?php echo $person['surname'];?>>
                </div>
            </div>
            <div id="pesel-div" class="form-group">
                <label for="pesel" class="col-sm-3 control-label">Pesel:</label>
                <div class="col-sm-9">
                    <input class="form-control" id="pesel" type=text disabled value=<?php echo $person['pesel'];?>>
                </div>
            </div>
            <div class="form-group">
                <label for="mail" class="col-sm-3 control-label">Mail:</label>
                <div class="col-sm-9">
                    <input class="form-control" type="email" placeholder="Mail" name="mail" required="true" value=<?php echo $person['mail'];?>>
                </div>
            </div>
            <div id="phone-div" class="form-group">
                <label for="phone-nr" class="col-sm-3 control-label">Nr telefonu:</label>
                <div class="col-sm-9">
                    <input class="form-control" type=text maxlength="9" placeholder="Numer telefonu" name="phone-nr" id="phone-nr" value=<?php echo $person['phone_nr'];?>>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <input class="btn btn-primary btn-sm" type=submit value="Edytuj dane">
                </div>
            </div>
    </form>
    </div>

</div>
<script>

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
        return ret;
    }



</script>
<?php createFooter(); ?>
</body>
</html>