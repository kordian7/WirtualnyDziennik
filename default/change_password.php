<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";

createHead();
if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}




if(isset($_POST['old-password']) && $_POST['old-password'] != null
&& isset($_POST['new-password']) && $_POST['new-password'] != null
&& isset($_POST['new-rep-password']) && $_POST['new-rep-password'] != null) {

    foreach($_POST as $key=>$value) {
        $_POST[$key] = mysqli_real_escape_string(getConnection(), $value);
    }
    mysqli_autocommit(getConnection(), false);
    $user = getUserInfo(getUserId());
    if($_POST['old-password'] != $user['hashed_pwd']) {
        header("Location: /~kokurd/default/change_password.php?success=bad-pwd");
        exit;
    } else if($_POST['new-password'] != $_POST['new-rep-password']) {
        header("Location: /~kokurd/default/change_password.php?success=diff-pwds");
        exit;
    } else {
        mysqli_query(getConnection(),"update user set hashed_pwd = '"
            .$_POST['new-password']
            ."' where us_id = "
            .$user['us_id']
            .";");
    }
    mysqli_commit(getConnection());
    header("Location: /~kokurd/default/change_password.php?success=true");
    exit;


}
createMenu();
?>
<br>
<div class='main'>
<?php
    if(isset($_GET['success'])) {
        if($_GET['success'] == 'true' ) {
            echo "
            <div class=\"alert alert-success alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Sukces</strong> Hasło zmienione
            </div>

        ";
        } elseif ($_GET['success'] == 'bad-pwd' ) {
            echo "
            <div class=\"alert alert-danger alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Error</strong> Błędne hasło
            </div>

        ";
        } elseif ($_GET['success'] == 'diff-pwds' ) {
            echo "
            <div class=\"alert alert-danger alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Error</strong> Nowe hasła się nie zgadzają
            </div>

        ";
        }

    }

?>

    <div class="div-h-centered" style="width: 500px">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 28px">Zmiana hasła</h1>
        </div>
        <form class="form-horizontal" action="change_password.php" method=POST onsubmit="return onSubmit();">
            <div class="form-group">
                <label for="inputOldPwd" class="col-sm-3 control-label">Stare hasło:</label>
                <div class="col-sm-9">
                    <input class="form-control" id="inputOldPwd" placeholder="Stare hasło" type=password  required="true">
                </div>
            </div>
            <div id="div-new1" class="form-group">
                <label for="inputNewPwd1" class="col-sm-3 control-label">Nowe hasło:</label>
                <div class="col-sm-9">
                    <input class="form-control" id="inputNewPwd1" placeholder="Nowe hasło" type=password  required="true">
                </div>
            </div>
            <div class="form-group">
                <label for="inputNewPwd2" class="col-sm-3 control-label">Powtórz nowe:</label>
                <div class="col-sm-9">
                    <input class="form-control" id="inputNewPwd2" placeholder="Powtórz nowe" type=password   required="true">
                </div>
            </div>
            <input type="hidden" id='hidden_pwd1' name="old-password" >
            <input type="hidden" id='hidden_pwd2' name="new-password" >
            <input type="hidden" id='hidden_pwd3' name="new-rep-password" >
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <input class="btn btn-primary btn-sm" type=submit value="Zmień hasło">
                </div>
            </div>
    </form>
    </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.5.0/js/md5.min.js"></script>
<script type="text/javascript">
    function onSubmit(){
        var ret = true;
        try {
            var oldPwd = $('#inputOldPwd').val();
            var newPwd1 = $('#inputNewPwd1').val();
            var newPwd2 = $('#inputNewPwd2').val();
            if(newPwd1.length < 5 ) {
                throw "tooShort";
            }
            $('#hidden_pwd1').val(md5(oldPwd));
            $('#hidden_pwd2').val(md5(newPwd1));
            $('#hidden_pwd3').val(md5(newPwd2));
        } catch(exc) {
            ret = false;
            document.getElementById("div-new1").className += " has-error";
        }

        return ret;
    }
</script>

<?php createFooter(); ?>
</body>
</html>