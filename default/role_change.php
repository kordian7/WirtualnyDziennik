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

createMenu();
echo "<br>
<div class='main'>
<form method='post' submit='/~kokurd/default/role_change.php'>";
$user_roles = getAvailableRoles();
if($_GET['selection'] == 'error') {
    echo '<div style="padding-bottom:15px">
		Problem z wybrana wartoscia
		</div> <br>';
}
foreach($user_roles as $k => $role){
    echo "<input type='radio' name='role' required='true' value='".$k."'>".$role."<br>";
}
echo "
<input  type=submit value=\"Potwierdź wybór\">
</form>";

echo "</div>";
?>

<?php createFooter(); ?>
</body>
</html>