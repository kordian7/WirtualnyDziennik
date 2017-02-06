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
    <div class="div-h-centered" style="width: width: 60%">
    <div style="text-align: center; font-size: 20px; ">
        <h1 style="text-align: center; font-size: 28px; ">
            Kontakt
        </h1>
    </div>
        <span>
            <br>
            Tu znajduje się informacja o sposobie kontaktu<br>
            <br>
            Jan Kowalski
            <br>
            Nr. telefonu: 123456789 <br>
            Godziny pracy: pn-pt 10:00-16:00
        </span>

</div>
</div>
<?php createFooter(); ?>
</body>
</html>