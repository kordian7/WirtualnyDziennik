<?php
include_once "../login_utils.php";
include_once "../protected/menu.php";
include_once "../school_db_utils.php";

if(isset($_POST['cr_id']) ) {
    $c_id = mysqli_escape_string(getConnection(), $_POST['cr_id']);
    printStudentList($c_id);
}

function printStudentList($c_id) {
    echo " 
        <option></option>";

        $students = getCourseStudents($c_id);
        while($st = mysqli_fetch_assoc($students)) {
            echo "
                    <option value={$st['st_id']}  > {$st['name']}  {$st['surname']} {$st['pesel']}</option>
                ";
        }
}


?>