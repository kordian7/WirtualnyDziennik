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
    <div class="div-h-centered" style="width: 100%">
    <div style="text-align: center;  ">
        <h1 style="text-align: center; font-size: 28px; ">
            Informacje o stronie
        </h1>
    </div>


</div>
</div>
<?php createFooter(); ?>
</body>
</html>