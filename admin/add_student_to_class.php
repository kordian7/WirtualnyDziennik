<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include "../login_utils.php";
include "../protected/menu.php";
include_once "../school_db_utils.php";


if(!checkIfLogged()) {
    header("Location: /~kokurd/");
}
if(!checkUserRole(getUserRole())) {
    header("Location: ".getIndexPath(getUserRole()));
}
if(isset($_POST['class-id']) && isset($_POST['student-id'])) {
    foreach ($_POST as $key=>$value) {
        $_POST[$key] = mysqli_real_escape_string(getConnection(), $value);
    }

    mysqli_query(getConnection(), "insert into student_class (st_id, cl_id, data_rozp) values
(".
        $_POST['student-id'].", ".
        $_POST['class-id'].", NOW() )");


    header("Location: /~kokurd/admin/add_student_to_class.php?success=true");
    exit;

}

createHead();
createMenu(); ?>

<br>
<div class='main'>
    <?php
    if(isset($_GET['success']) && $_GET['success'] == 'true' ) {
        echo "
            <div class=\"alert alert-success alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Sukces</strong> Dodano ucznia do klasy
            </div>

        ";
    }
    if(isset($_GET['success']) && $_GET['success'] == 'false' ) {
        echo "
            <div class=\"alert alert-danger alert-dismissable\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
            <strong>Error</strong> Wystąpił problem z dodaniem ucznia do klasy
            </div>

        ";
    }
    ?>


    <div class="div-h-centered" style="width: 500px">
        <div style="text-align: center; font-size: 28px; ">
            <h1 style="font-size: 20px; ">
                Dodawanie ucznia do klasy
            </h1>
        </div>

        <form  class="form-horizontal" action="add_student_to_class.php" method=POST>
            <div class="form-group">
                <label for="id-kursu" class="col-sm-3 control-label">Uczeń:</label>
                <div class="col-sm-9">
                    <select id="select-student" name="student-id" class="chosen-select" data-placeholder="Wybierz ucznia: " required="true">
                        <option> </option>
                    <?php
                    $students = getStudentsWithoutClass();
                    while($st = mysqli_fetch_assoc($students)) {
                        echo "
                    <br>
                    <option value={$st['st_id']}  > {$st['name']}  {$st['surname']} {$st['pesel']} </option>";
                    } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="select-class" class="col-sm-3 control-label">Klasa:</label>
                <div class="col-sm-9">
                    <select id="select-class" name="class-id" class="chosen-select" data-placeholder="Wybierz klasę: "  required="true">
                        <option> </option>
                        <?php
                        $classes = getActiveClasses();
                        while($cl = mysqli_fetch_assoc($classes)) {
                            echo "
                    <br>
                    <option value={$cl['class_id']}  > {$cl['year']}{$cl['section']}  </option>";
                        } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <input class="btn btn-primary btn-sm" type=submit value="Dodaj ucznia">
                </div>
            </div>
        </form>



    </div>
    </div>

<?php createFooter(); ?>




</body>
</html>