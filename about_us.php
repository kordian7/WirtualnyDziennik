<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
include "login_utils.php";
include "protected/menu.php";
createHead();

if(checkIfLogged()) {
    createMenu(getUserId());
} else {
    createPublicMenu();
}

?>

<body>
<div class='main'>
About us
<br>
<?php
if(checkIfLogged()) {
    //header("Location: ".getIndexPath(getUserRole()));
    echo getIndexPath(getUserRole())." <br/>".getUserRole()."::";
}
?>



</div>
<?php createFooter(); ?>
</body>
</html>