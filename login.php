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
    $_POST[$key] = mysqli_real_escape_string($connection, $value);
}

if(isset($_POST['username'])) {
    $query = mysqli_query(getConnection(), "SELECT count(*) cnt, us_id 
	FROM user where username = '{$_POST['username']}' and hashed_pwd = '".md5($_POST['password'])."';");
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

<html>
<head>
<meta charset="utf-8">
<title>Logowanie</title>
<style>
html,body {
  height:100%;
  width:100%;
  margin:0;
}
body {
  display:flex;
}
form {
  margin:auto;/* nice thing of auto margin if display:flex; it center both horizontal and vertical :) */
	margin-top:10%;
  }
</style>
</head>

<body>
<br/>

        <form action="login.php" method=post>
		
		<div style="padding-bottom:150px; text-align:center; font-size:28px; width:100%">
		Logowanie
		</div>
            <?php
        if($_GET['access'] == 'denied') {
            echo '<div style="padding-bottom:15px">
		Blad logowania
		</div>';
        }
        ?>
		<div style="padding-bottom:15px">
		Login: <input type=text name="username" required="true">
		</div>
		<div>
		Hasło: <input type=password name="password" required="true">
		</div>
		</br>
		<div style="text-align:center; padding-top:20px">
		<input  type=submit value="Zaloguj">
		</div>
	</form>';
<?php createFooter(); ?>
</body>
</html>