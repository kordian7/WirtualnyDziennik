<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include "login_utils.php";
include "protected/menu.php";
createHead();
if(checkIfLogged()) {
    header("Location: ".getIndexPath(getUserRole()));
    echo getIndexPath(getUserRole())." <br/>".getUserRole()."::";
}

createPublicMenu();
?>

<body>
<div class="main" ></div>
<div class='main'>
    <div class="div-h-centered" style="width: 80%">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 28px">Strona główna</h1>
        </div>
        <span>
            Witaj w naszej aplikacji.<br> Aktualnie nie jesteś zalogowany. Aby
            móc pracować w serwisie zaloguj się.
        </span>
    </div>
</div>



</div>
<?php createFooter(); ?>
</body>
</html>