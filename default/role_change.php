<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";

if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}
if(count(getAvailableRoles()) <= 1) {
    header("Location: /~kokurd/");
    exit;
}


if(isset($_POST['role'])) {
    $user_roles = getAvailableRoles();
    $isCorrect = false;
    foreach ($user_roles as $k => $role) {
        if ($k == $_POST['role']) {
            $isCorrect = true;
            break;
        }
    }
    if ($isCorrect) {
    mysqli_query($connection, "update session set role_id = {$_POST['role']}
                where ses_us_id = " . getUserId() . ";");
    header("Location: /~kokurd/");
    exit;
    } else {
        header("Location: /~kokurd/default/role_change.php?selection=error&role=".$_POST['role']);
        exit;
    }
}

createHead();


echo "<body>";
createMenu(); ?>
<br>
<div class='main'>

    <div class="div-h-centered" style="width: 500px">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 28px">Zmiana funkcji</h1>
        </div>
        <form class="form-horizontal" role='form' method='post' submit='/~kokurd/default/role_change.php'>

    <?php
$user_roles = getAvailableRoles();
if($_GET['selection'] == 'error') {
    echo "
            <div class=\"alert alert-danger alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Error</strong> Problem z wybraną wartością
            </div>

        ";
}
foreach($user_roles as $k => $role){
    echo "
     <div class=\"form-group\">
                <label class=\"col-sm-3 control-label\">".$role."</label>
                <div class=\"col-sm-9\">
                    <input class=\"form-control\" type='radio' name='role' required='true' value='".$k."'>
                </div>
            </div>
    
    
    <br>";
} ?>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <input class="btn btn-primary btn-sm" type=submit value="Potwierdź wybór">
                </div>
            </div>
        </form>
</div>
</div>
<?php createFooter(); ?>
</body>
</html>