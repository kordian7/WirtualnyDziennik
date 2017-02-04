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
createMenu();

// DODANIE UZYTKOWNIKA DO BAZY
// TRANSAKCJA

if(isset($_POST['username']) && $_POST['username'] != null && isset($_POST['person']) && $_POST['person'] != null) {
    $_POST['username'] = str_replace(' ', '', $_POST['username']);
    $oldUsername = $_POST['username'];
    foreach($_POST as $key=>$value) {
        $_POST[$key] = mysqli_real_escape_string(getConnection(), $value);
    }
    // Start transakcji
    if(checkIfLoginExists($_POST['username'])) {
        header("Location: /~kokurd/admin/add_user.php?success=user_already_exists");
        exit;
    }
    mysqli_autocommit(getConnection(),FALSE);
    $password = substr(hash('sha512',rand()),0,10);
    $passwordHashed = md5($password);
    mysqli_query(getConnection(), "insert into user(username, hashed_pwd, pr_id) values
	  ('{$_POST['username']}', '{$passwordHashed}', {$_POST['person']});");


    $user_id = mysqli_insert_id(getConnection());
    if($_POST['admin'] == 'true') {
        mysqli_query(getConnection(), "insert into user_role(us_id, role_id) values
		({$user_id}, 1);");
    }
    // Sprawdzanie czy jest person jeśli tak to ustawianie ról
    ustawRole($user_id, $_POST['person']);
    $person_arr = getPersonInfo($_POST['person']);
    mail($person_arr['mail'], "Witaj w Wirtualnym Dzienniku", "Twoje konto zostało dodane w serwisie Wirtualny Dziennik.\nTwoje dane do zalogowania:\nLogin: ".$oldUsername."\nHasło: ".$password."\n\nZmień hasło przy pierwszej wizycie!.");

    mysqli_commit(getConnection());

    header("Location: /~kokurd/admin/add_user.php?success=true");
    exit;


}












?>
<br>
<div class='main'>
<?php
    if(isset($_GET['success']) && $_GET['success'] == 'true' ) {
        echo "
            <div class='success'>
                Dodano nowego użytkownika
            </div>
        ";
    }
?>

Dodawanie nowego użytkownika
    <form action="add_user.php" method=POST>
        <table class="form-table">

        <tr><td>
                Login: </td><td> <input type=text name="username" id="login" onblur="checkLogin();" required="true"> </td> <span id="login-check"> </span>
        </tr>
        <tr><td>
                Osoba: </td><td><select class="chosen-select" data-placeholder="Wybierz użytkownika" name="person" >
                    <br>
                    <option> </option>

        <?php
            $people = getPeopleWithNoUser();
            while($person = mysqli_fetch_assoc($people)) {
                echo "
                    <br>
                    <option value={$person['pr_id']}  > {$person['surname']}  {$person['name']} {$person['pesel']} </option>
                ";
            }

        ?>
        </select>
            </td></tr>
        <!-- Dodawanie admina tylko w bazie???
        <tr><td>
               Administrator: </td><td> <input  type="checkbox" name="admin" value="true" > </td>
        </tr>
        -->
        <tr><td colspan="2">
            <input  type=submit value="Dodaj użytkownika">
                </td></tr>
        </table>
    </form>
<script type="text/javascript">
    var XMLHttp = getXMLHttp();

    function checkLogin() {
        login = document.getElementById('login').value;
        console.log("login=" + login);
        XMLHttp.open("POST", "/~kokurd/login_check.php");
        XMLHttp.onreadystatechange = handler;
        XMLHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XMLHttp.send("login=" + login);
    }

    function handler() {
        if(XMLHttp.readyState == 4) {
            document.getElementById('login-check').innerHTML=XMLHttp.responseText;
        }
    }

</script>
</div>
<?php createFooter(); ?>
</body>
</html>