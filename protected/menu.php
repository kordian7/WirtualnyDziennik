<?php

include_once "../baza.php";


function createMenu() {
    $us_id = getUserId();
    $m_user = mysqli_fetch_assoc(mysqli_query(getConnection(),
        "select pr_id from user where us_id = {$us_id};"));
    $m_pr_id = $m_user['pr_id'];
    $m_person = getPersonInfo($m_pr_id);
    $session_arr = mysqli_fetch_assoc(mysqli_query(getConnection(),
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
<style>


}



</style>

<nav>
<div class='topmenu-div'>
    <ul id='myTopmenu' class=\"topmenu\">";
    if($m_role != null) {
        echo "<li> <a href='javascript:void(0)' onclick=\"toggleSideMenu()\"><span class=\"glyphicon glyphicon-menu-hamburger\" /> </a> </li>";
    }

    echo "<li > <a href='/~kokurd\' >
            <span class=\"glyphicon glyphicon-home\" />     
                </a> </li>
            <li style='padding-left: 40px' class='topmenu-userinfo'> 
                
                <a href=\"javascript:void(0)\"  class=\"topmenu-userinfo-btn\" onClick='showUserinfoMenu()' >
                    {$m_person['name']} {$m_person['surname']} Zalogowany jako: {$roleStr} </a>
            <div class='topmenu-userinfo-content' id='myUserinfoContent' >
                <a href='/~kokurd/default/edytuj_dane.php'> Moje dane </a>
                <a href='/~kokurd/default/change_password.php'> Zmiana hasła </a>";

                if(count(getAvailableRoles()) > 1)
                    echo "<a href='/~kokurd/default/role_change.php'> Zmien swoja funkcje </a>";
            echo "
            </div>
        </li>
        
        
        <li style='float: right; padding-right: 20px'> <a href=\"/~kokurd/logout.php\"><span class=\"glyphicon glyphicon-log-out\" /> </a> </li>
          <li style='float: right; padding-right: 20px'> <a href=\"/~kokurd/kontakt.php\">Kontakt</a> </li>
        <li style='float: right; padding-right: 20px'> <a href=\"/~kokurd/about_us.php\">Informacje o stronie</a> </li>
    </ul>
</div></nav>";
if($m_role != null) {
    echo "<div id='sidemenu-id' class='sidemenu'>"
        .createSideMenuContent($m_role)
        ."</div>";
}
echo "
<script>
    
    function setMainWidth() {
        document.getElementsByClassName(\"main\")[0].style.marginLeft = \"8px\";
    }
    function showUserinfoMenu() {
        document.getElementById(\"myUserinfoContent\").classList.toggle(\"show-menu\");
    }
    
    window.onclick = function(event) {
  if (!event.target.matches('.topmenu-userinfo-btn')) {

    var dropdowns = document.getElementsByClassName(\"topmenu-userinfo-content\");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show-menu')) {
        openDropdown.classList.remove('show-menu');
      }
    }
  }
}
    
    function toggleSideMenu() {
        console.log('wd: ' + $('#sidemenu-id').width());
        if($('#sidemenu-id').width() == 0) {
            $('#sidemenu-id').width(200);
            $('.main').css('marginLeft','208px');
           } else {
            $('#sidemenu-id').width(0);
            $('.main').css('marginLeft','8px');
        
        }
    }

    
    ";
    if($m_role != null) {
        echo "window.onload = setMainWidth;";
    };
 echo "
</script>";

}

function createPublicMenu() {

    echo "
<div class='topmenu-div'>
    <ul class=\"topmenu\">";
    echo "
        <li > <a href='/~kokurd\' >
            <span class=\"glyphicon glyphicon-home\" />     
                </a> </li>
        <li style='float: right; padding-right: 20px'> <a href=\"/~kokurd/login.php\">Zaloguj</a> </li>
        <li style='float: right; padding-right: 20px'> <a href=\"/~kokurd/kontakt.php\">Kontakt</a> </li>
        <li style='float: right; padding-right: 20px'> <a href=\"/~kokurd/about_us.php\">Informacje o stronie</a> </li>
        
    </ul>
</div>";

}



function createSideMenuContent($m_role) {
    switch($m_role) {
        case "admin":
            return "
            <a href=\"/~kokurd/admin/add_person.php\">Dodaj osobę</a>
            <a href=\"/~kokurd/admin/add_user.php\">Dodaj użytkownika</a>
            <a href=\" /~kokurd/admin/remove_user.php\">Usuń użytkownika</a>
            <a href=\"/~kokurd/admin/remove_person.php\">Usuń osobę</a>
            <a href=\"/~kokurd/admin/add_student_to_class.php\">Dodaj ucznia do klasy</a>
            ";
        case "teacher":
            return "
            <a href=\"/~kokurd/teacher/add_marks.php\">Dodaj oceny</a>
            <a href=\"/~kokurd/teacher/add_absence.php\">Dodaj nieobecność</a>
            <a href=\"/~kokurd/teacher/show_absences.php\">Sprawdź nieobecności</a>
            ";
        case "student":
            return "
            <a href=\"/~kokurd/student/show_courses.php\">Pokaż przedmioty</a>
            <a href=\"/~kokurd/student/show_absences.php\">Sprawdź nieobecności</a>
            ";
        case "parent":
            return "
            <a href=\"/~kokurd/parent/show_courses.php\">Pokaż oceny</a>
            <a href=\"/~kokurd/parent/show_absences.php\">Sprawdź nieobecności</a>
            ";
        default:
            return "";
    }
}

function createHead() {
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0, max-age=0", false);
    header("Pragma: no-cache");
    echo "
    <head>  
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf8_polish_ci\" />  
<title>Wirtualny dziennik</title>
      <script src=\"/~kokurd/js/jquery-3.1.1.min.js\" type='text/javascript'></script>
      <script src=\"/~kokurd/js/jquery-ui-1.12.1/jquery-ui.js\" type='text/javascript'></script>

<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
<link rel='stylesheet' href='/~kokurd/css/awesome-bootstrap-checkbox.css' type='text/css' />
<link rel='stylesheet' href='/~kokurd/js/jquery-ui-1.12.1/jquery-ui.css' type='text/css' />
    <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
         <script src=\"http://harvesthq.github.io/chosen/chosen.jquery.js\"></script>
     <script src=\"/~kokurd/js/scripts.js\" type='text/javascript'></script>

<!-- Bootstrap select -->
<!-- Latest compiled and minified CSS -->
<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css\">

<!-- Latest compiled and minified JavaScript -->
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js\"></script>

     <link rel='stylesheet' href='/~kokurd/css/chosen.css' type='text/css' />
<link rel='stylesheet' href='/~kokurd/css/wd.css' type='text/css' />
<noscript>
            <div style='margin-top: 100px' class=\"alert alert-danger \">
    < strong> Error </strong > Twoja strona nie obsługuje JavaScriptu. Serwis może nie działać poprawnie.
    </div >

</noscript>
</head> 
";
}

function createFooter() {
    showCookie();
}

function showCookie() {
    if(!isset($_COOKIE['showCookie'])) {
        setcookie("showCookie", "true",0,"/~kokurd/");
    }
    if ($_COOKIE['showCookie']=='true') {
        echo "
            <div class='cookie-info' id='cookie-info-id'>
                <strong>
                    Strona korzysta z plików Cookies zgodnie z polityką plików cookies. Zamykając tą informację zgadzasz się na to. 
                    </strong>
                    <span onclick='setShowCookieFalse()' class=\" close-btn glyphicon glyphicon-remove\"></span>
            </div>
        ";
    }
}

?>