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


if(isset($_POST['us_id'])) {
    $user = getUserInfo($_POST['us_id']);
    if(!mysqli_query(getConnection(), "delete from user where us_id="
    .$_POST['us_id'])) {
        header("Location: /~kokurd/admin/remove_user.php?success=false");
        exit;
    }
    mysqli_query(getConnection(), "insert into user_logs(ip, us_username, type ) values 
        ( '{$_SERVER['REMOTE_ADDR']}', '{$user['username']}', 'account_remove' );");
    header("Location: /~kokurd/admin/remove_user.php?success=true");
    exit;

}
createMenu();
?>
<body>
<div class='main'>


    <?php
    if(isset($_GET['success']) && $_GET['success'] == 'true' ) {
        echo "
            <div class=\"alert alert-success alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Sukces</strong> Użytkownik usunięty
            </div>

        ";
    }
    if(isset($_GET['success']) && $_GET['success'] == 'user_already_exists' ) {
        echo "
            <div class=\"alert alert-danger alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Error</strong> Problem z usunięciem użytkownika
            </div>

        ";
    }
    ?>


    <div class="div-h-centered" style="width: 500px">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 28px">Usuwanie użytkownika</h1>
        </div>
    <form  class="form-horizontal" action="remove_user.php" method=POST>
        <div class="form-group">
            <label for="inputUser" class="col-sm-3 control-label">Użytownik:</label>
            <div class="col-sm-9">
                <select id='inputUser' class="chosen-select" data-placeholder="Wybierz użytkownika" name="us_id" >
                        <option> </option>

                    <?php
                    $users = getUsersWithoutAdms();
                    while($us = mysqli_fetch_assoc($users)) {
                    echo "<option value=".$us['us_id']."  > ".$us['username']."  </option>";
                    }

                        ?>
                    </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <input class="btn btn-primary btn-sm" type=submit value="Usuń użytkownika">
            </div>
        </div>

    </form>

    </div>

</div>
<?php createFooter(); ?>
</body>
</html>