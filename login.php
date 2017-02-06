<!DOCTYPE HTML>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

include "login_utils.php";
include "protected/menu.php";
createHead();
if(checkIfLogged()) {
    header("Location: ".getIndexPath(getUserRole()));
    echo getIndexPath(getUserRole())." <br/>".getUserRole()."::";
}

createPublicMenu();

foreach ($_POST as $key=>$value) {
    $_POST[$key] = mysqli_real_escape_string(getConnection(), $value);
}

if(isset($_POST['username'])) {
    $query = mysqli_query(getConnection(), "SELECT count(*) cnt, us_id 
	FROM user where username = '{$_POST['username']}' and hashed_pwd = '".$_POST['hashed_pwd']."';");
    $checkuser = mysqli_fetch_assoc($query);

    $user_role_result = mysqli_query(getConnection(), "select role_id, role from v_user_role where us_id = {$checkuser['us_id']};");
    $user_role_ass = mysqli_fetch_assoc($user_role_result);
    if($checkuser['cnt']) {
        $id = md5(rand(-10000, 10000) . microtime()) . md5(crc32(microtime()) .
                $_SERVER['REMOTE_ADDR']);
        mysqli_query(getConnection(), "delete from session where ses_us_id = '{$checkuser['us_id']}';");
        mysqli_query(getConnection(), "insert into session(ses_us_id, id, ip, web) values
		({$checkuser['us_id']}, '{$id}', '{$_SERVER['REMOTE_ADDR']}', '{$_SERVER['HTTP_USER_AGENT']}');");
        if(mysqli_errno(getConnection())) {
            header("Location:login.php?access=database_error");
            exit;
        } else {
            setcookie("id", $id);
            $role = null;
            mysqli_query(getConnection(), "insert into user_logs(ip, us_username, type ) values 
        ( '{$_SERVER['REMOTE_ADDR']}', '{$_POST['username']}', 'good_login');");
            mysqli_query(getConnection(), "update user_logs set type='bad_login_u' where type='bad_login' and 
            us_username='{$_POST['username']}' and TIMESTAMPDIFF(MINUTE, time, now()) < 30;");


            if (mysqli_num_rows($user_role_result) == 1) {
                mysqli_query($connection, "update session set role_id = {$user_role_ass['role_id']}
                where ses_us_id = {$checkuser['us_id']};");
                $role = $user_role_ass['role'];
            } elseif (mysqli_num_rows($user_role_result) > 1) {

                header("Location: /~kokurd/default/role_change.php");
                exit;
            }

            header("Location: ".getIndexPath($role));
            exit;
            // przekierowanie
        }


    } else {
        mysqli_query(getConnection(), "insert into user_logs(ip, us_username, type ) values 
        ( '{$_SERVER['REMOTE_ADDR']}', '{$_POST['username']}', 'bad_login');");
       
        header("Location:login.php?access=denied");
        exit;
    }
};
?>

<body>
<div class='main'>

<style>
    .div-login {
        position: fixed;
        left: 50%;
        top: 35%;
        transform: translate(-50%, -50%);
    }
</style>

<?php
if($_GET['access'] == 'denied') {
    echo '<div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error</strong> Błąd logowania
            </div>';
}
?>


    <div class="div-h-centered" style="width: 500px">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 28px">Logowanie</h1>
        </div>


        <form id='form-id' class="form-horizontal" action="login.php" method=post onsubmit="onSubmit();">
            <div  class="form-group">
                <label for="inputLogin" class="col-sm-3 control-label">Login:</label>
                <div class="col-sm-9">
                    <input class="form-control" id="inputLogin" type=text  placeholder="Login" name="username" required="true">
                </div>
            </div>
            <div  class="form-group">
                <label for="inputPassword" class="col-sm-3 control-label">Hasło:</label>
                <div class="col-sm-9">
                    <input class="form-control" id="inputPassword" type=password  placeholder="Hasło"  required="true">
                </div>
            </div>
            <input type="hidden" id='hidden_pwd' name='hashed_pwd' >
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <input class="btn btn-primary btn-sm" type=submit value="Zaloguj">
                </div>
            </div>
	</form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.5.0/js/md5.min.js"></script>
    <script type="text/javascript">
        function onSubmit(){
            var password = $('#inputPassword').val();
            $('#hidden_pwd').val(md5(password));
            $("form-id").children('#inputPassword').remove();
        }
    </script>
<?php createFooter(); ?>
</body>
</html>