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
$user = getUserInfo(getUserId());

if(isset($_POST['old-password']) && $_POST['old-password'] != null
&& isset($_POST['new-password']) && $_POST['new-password'] != null
&& isset($_POST['new-rep-password']) && $_POST['new-rep-password'] != null) {

    foreach($_POST as $key=>$value) {
        $_POST[$key] = mysqli_real_escape_string(getConnection(), $value);
    }
    if(md5($_POST['old-password']) != $user['hashed_pwd']) {
        header("Location: /~kokurd/default/change_password.php?success=bad-pwd");
        exit;
    } else if($_POST['new-password'] != $_POST['new-rep-password']) {
        header("Location: /~kokurd/default/change_password.php?success=diff-pwds");
        exit;
    } else {
        mysqli_query(getConnection(),"update user set hashed_pwd = '"
            .md5($_POST['new-password'])
            ."' where us_id = "
            .$user['us_id']
            .";");
    }



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
                Hasło zmienione
            </div>
        ";
    }
?>

Zmiana hasła
    <form action="change_password.php" method=POST onsubmit="return validateForm()">
        <table class="form-table">

            <tr><td>
                    Stare hasło: </td><td> <input type=password name="old-password" required="true"> </td>
            </tr>
            <tr><td>
                    Nowe hasło: </td><td> <input type=password name="new-password" required="true"></td>
            </tr>
            <tr><td>
                    Powtórz nowe: </td><td> <input type=password name="new-rep-password" required="true"></td>
            </tr>


        <tr><td colspan="2">
            <input  type=submit value="Zmień hasło">
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
               ;// ret = false;
            }
        }
        return ret;
    }



</script>
<?php createFooter(); ?>
</body>
</html>