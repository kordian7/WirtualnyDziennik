<?php

include_once "baza.php";


function createMenu($us_id) {


    global $connection;

    $m_user = mysqli_fetch_assoc(mysqli_query($connection,
        "select pr_id from user where us_id = '{$us_id}';"));
    $m_user = mysqli_fetch_assoc(mysqli_query($connection,
        "select pr_id from user where us_id = '{$us_id}';"));
    $m_pr_id = $m_user['pr_id'];
    $m_person = mysqli_fetch_assoc(mysqli_query($connection, "select pr_id, name, surname, pesel from person where pr_id = {$m_pr_id};"));
    $session_arr = mysqli_fetch_assoc(mysqli_query($connection,
        "select role from session left join role_type on session.role_id = role_type.role_id
    where ses_us_id = {$us_id};"));
    $m_role =  $session_arr['role'];
    $roleStr = null;
    switch($m_role) {
        case "admin":
            $roleStr = "Administrator";
            break;
        case "teacher":
            $roleStr = "Nauczyciel";
            break;
        case "student":
            $roleStr = "Uczen";
            break;
        case "parent":
            $roleStr = "Rodzic";
            break;
        default:
            $roleStr = "Nie wybrano funkcji";
            break;
    }
    echo "
<div class='topmenu-div'>
    <ul class=\"topmenu\">";
    if($m_role != null) {
        echo "<li style='padding-left: 20px'> <a href='javascript:void(0)' onclick=\"toggleSideMenu()\">&#9776;</a> </li>";
    }
    echo "<li style='padding-left: 30px' class='topmenu-userinfo'> <a href=\"#\" class=\"topmenu-userinfo-btn\" onClick='showUserinfoMenu()' >{$m_person['name']} {$m_person['surname']} Zalogowany jako: {$roleStr} </a>
            <div class='topmenu-userinfo-content' id='myUserinfoContent' >
                <a href='#'> Moje dane </a>
                <a href='#'> Zmien swoja funkcje </a>
            </div>
        </li>
        <li style='float: right; padding-right: 60px'> <a href=\"?logout\">Wyloguj</a> </li>
        <li style='float: right; padding-right: 30px'> <a href=\"\~kokurd/index.php\">Strona glowna</a> </li>
        
    </ul>
</div>";
if($m_role != null) {
    echo "<div class='sidemenu'>"
        .createSideMenuContent($m_role)
        ."</div>";
}
echo "
<script>
    function showUserinfoMenu() {
        document.getElementById(\"myUserinfoContent\").classList.toggle(\"show-menu\");
    }
    
    function toggleSideMenu() {
        console.log(document.getElementsByClassName('sidemenu')[0].style.width);
        if(document.getElementsByClassName('sidemenu')[0].style.width == \"0px\") {
        console.log(1);
        
            document.getElementsByClassName(\"sidemenu\")[0].style.width = \"200px\";
            document.getElementsByClassName(\"main\")[0].style.marginLeft = \"208px\";
        } else {
        console.log(2);
            document.getElementsByClassName(\"sidemenu\")[0].style.width = \"0px\";
            document.getElementsByClassName(\"main\")[0].style.marginLeft = \"8px\";
        }
    }
    
    function loadCSS() {
        var file = document.createElement(\"link\");
        file.setAttribute(\"rel\", \"stylesheet\");
       file.setAttribute(\"type\", \"text/css\");
       file.setAttribute(\"href\", \"/~kokurd/protected/wd.css\");
       document.head.appendChild(file);
    }
    
    loadCSS();
</script>";

}

function createSideMenuContent($m_role) {
    switch($m_role) {
        case "admin":
            return "
            <a href=\"#\">Adm 1</a>
            <a href=\"#\">Adm 2</a>
            ";
        case "teacher":
            return "
            <a href=\"#\">Adm 1</a>
            <a href=\"#\">Adm 2</a>
            ";
        case "student":
            return "
            <a href=\"#\">Adm 1</a>
            <a href=\"#\">Adm 2</a>
            ";
        case "parent":
            return "
            <a href=\"#\">Adm 1</a>
            <a href=\"#\">Adm 2</a>
            ";
        default:
            return "";
    }
}

?>