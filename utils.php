<?php

function getCurrentSchoolYear() {
    $month = date("n");
    if($month >= 9) {
        return date("Y");
    } else {
        return date("Y") - 1;
    }
}


?>