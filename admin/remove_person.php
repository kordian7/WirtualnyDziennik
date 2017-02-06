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


if(isset($_POST['pr_id'])) {
    if(!mysqli_query(getConnection(), "delete from person where pr_id="
    .$_POST['pr_id'])) {
        header("Location: /~kokurd/admin/remove_person.php?success=false");
        exit;
    }
    header("Location: /~kokurd/admin/remove_person.php?success=true");
    exit;

}
createMenu();
?>
<body>
<div class='main'>


    <?php
    if(isset($_GET['success']) && $_GET['success'] == 'true' ) {
        echo "
            <div class=\"alert alert-success alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Sukces</strong> Osoba usunięta z bazy
            </div>

        ";
    }
    if(isset($_GET['success']) && $_GET['success'] == 'false' ) {
        echo "
            <div class=\"alert alert-danger alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Error</strong> Nie można usunąć osoby
            </div>

        ";
    }
    ?>


    <div class="div-h-centered" style="width: 500px">
        <div class="page-header" style="text-align: center">
            <h1 style="font-size: 28px">Usuwanie osoby</h1>
        </div>
    <form  class="form-horizontal" action="remove_person.php" method=POST>
        <div class="form-group">
            <label for="inputUser" class="col-sm-3 control-label">Osoba:</label>
            <div class="col-sm-9">
                <select id='inputUser' class="chosen-select" data-placeholder="Wybierz osobę" name="pr_id" >
                        <option> </option>

                    <?php
                    $people = getPeopleWithNoUser();
                    while($person = mysqli_fetch_assoc($people)) {
                    echo "<option value={$person['pr_id']}  > {$person['surname']}  {$person['name']} {$person['pesel']} </option>";
                    }

                        ?>
                    </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <input class="btn btn-primary btn-sm" type=submit value="Usuń użytkownika">
            </div>
        </div>

    </form>

    </div>

</div>
<?php createFooter(); ?>
</body>
</html>