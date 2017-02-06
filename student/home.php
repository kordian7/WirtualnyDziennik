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
createMenu();?>

<div class='main'>
    <div class="div-h-centered" style="width: 80%">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 28px">Strona główna</h1>
        </div>
        <span>
            Witaj w naszym serwisie.<br> Aktualnie jesteś zalogowany jako uczeń.
            Jeżeli po kliknięciu na swoje dane w menu pojawi się opcja "zmień funkcję" to
            znaczy, że możesz pracować w innej roli w systemie.
        </span>
    </div>
</div>

<?php createFooter(); ?>
</body>
</html>