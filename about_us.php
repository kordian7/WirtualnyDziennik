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
    <div class="div-h-centered" style="width: 80%">
    <div style="text-align: center;  ">
        <h1 style="text-align: center; font-size: 28px; ">
            Informacje o stronie
        </h1>
    </div>
        <br>
        <span>
            Tu znajduje się informacja o naszym serwisie<br> Lorem ipsum dolor
            sit amet, consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
            commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
            occaecat cupidatat non proident, sunt in culpa qui officia deserunt
            mollit anim id est laborum.
        </span>

</div>
</div>
<?php createFooter(); ?>
</body>
</html>