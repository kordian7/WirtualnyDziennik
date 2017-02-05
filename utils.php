<?php

function getCurrentSchoolYear() {
    $month = date("n");
    if($month >= 9) {
        return date("Y");
    } else {
        return date("Y") - 1;
    }
}

function getMarksOptions($mark) {
    $tab[0]="0";
    $tab[1]="1";
    $tab[2]="1+";
    $tab[3]="2-";
    $tab[4]="2";
    $tab[5]="2+";
    $tab[6]="3-";
    $tab[7]="3";
    $tab[8]="3+";
    $tab[9]="4-";
    $tab[10]="4";
    $tab[11]="4+";
    $tab[12]="5-";
    $tab[13]="5";
    $tab[14]="5+";
    $tab[15]="6-";
    $tab[16]="6";
    $ret ="";
    if($mark == null)
        $ret ="<option></option>";
    else
        $ret ="<option selected></option>";
    for($i=0;$i<=16;$i++) {
        if($tab[$i] == $mark)
            $ret = $ret."<option selected>".$tab[$i]."</option>\n";
        else
            $ret = $ret."<option>".$tab[$i]."</option>\n";
    }

    return $ret;
}


function getNewMarksOptions() {
    $tab[0]="0";
    $tab[1]="1";
    $tab[2]="1+";
    $tab[3]="2-";
    $tab[4]="2";
    $tab[5]="2+";
    $tab[6]="3-";
    $tab[7]="3";
    $tab[8]="3+";
    $tab[9]="4-";
    $tab[10]="4";
    $tab[11]="4+";
    $tab[12]="5-";
    $tab[13]="5";
    $tab[14]="5+";
    $tab[15]="6-";
    $tab[16]="6";
    $ret ="";
    for($i=0;$i<=16;$i++) {
            $ret = $ret."<option>".$tab[$i]."</option>\n";
    }

    return $ret;
}

?>