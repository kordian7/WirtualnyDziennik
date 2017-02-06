<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf8_polish_ci" />  
<title>Wirtualny dziennik</title>
</head>  
<body>  

<?php
include "loginUtils.php";
include "protected/menu.php";
createMenu($session_arr['ses_us_id']);
?>
<div class='main' >
<div class="div-centered" style="width:520px; top:120px">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 20px">Strona główna</h1>
        </div>
    </div>

</div>
</body>
</html>