<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";

createHead();
if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}

createMenu();
// Transaction!!!!!!!
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

?>
<br>
<div class='main'>
<?php
    if(isset($_GET['success']) && $_GET['success'] == 'true' ) {
        echo "
            <div class='success'>
                Dane zmienione
            </div>
        ";
    }
?>

Dodawanie nowego użytkownika
    <form action="edytuj_dane.php" method=POST onsubmit="return validateForm()">
        <table class="form-table">

            <tr><td>
                    Imię: </td><td> <input type=text disabled value=<?php echo $person['name'];?>> </td>
            </tr>
            <tr><td>
                    Nazwisko: </td><td> <input type=text disabled value=<?php echo $person['surname'];?>>
            </tr>
            <tr><td>
                    Pesel: </td><td> <input type=text disabled value=<?php echo $person['pesel'];?>>
            </tr>
            <tr><td>
                    Mail: </td><td> <input type=text name="mail" required="true" value=<?php echo $person['mail'];?>>
            </tr>
            <tr><td>
                    Nr telefonu: </td><td> <input type=text maxlength="9" name="phone-nr" id="phone-nr" value=<?php echo $person['phone_nr'];?>>
            </tr>


        <tr><td colspan="2">
            <input  type=submit value="Edytuj dane">
                </td></tr>
        </table>
    </form>

</div>
<script>

    function validateForm() {
        var nrPatt = /^\d{9}$/;
        var peselPatt = /^\d{11}$/;
        var ret = true;
        if(document.getElementById("phone-nr").value != "") {
            if(!document.getElementById("phone-nr").value.match(nrPatt)){
                ret = false;
            }
        }
        return ret;
    }



</script>
<?php createFooter(); ?>
</body>
</html>