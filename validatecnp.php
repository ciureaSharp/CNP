<?php
/**
 * Created by PhpStorm.
 * User: ciure
 * Date: 4/24/2017
 * Time: 18:35
 */
include ('randomcnp.php');



    // dimensiunea cnp ului
    if (strlen($cnp) != 13) {
        return 'CNP trebuie sa aiba 13 caractere';
        exit;
    }

    // caracterele sunt cifre
    if (!is_numeric($cnp)) {
        return 'CNP trebuie sa contina numai cifre';
        exit;
    }

    // data nasterii
    $data_nasterii = $zi . '-' . $luna . '-' . $anfull;

    // validate date
    if (!checkdate($luna, $zi, $anfull) || !validare($cnp)) {
        return "CNP invalid";
        exit;
    }

    setlocale(LC_TIME, 'ro_RO');
    $data_nasterii = date('Y-F-d', strtotime($data_nasterii));

    $date1 = date_create(date('Y-m-d', time()));
    $date2 = date_create(date('Y-m-d', strtotime($data_nasterii)));
    $varsta = date_diff($date1, $date2)->y;



function validare($cnp)
{

    $cnp = (string)$cnp;
    $key = str_split(279146358279);
    $key_control = $cnp[12];

    $cnp_array = array();

    for ($i = 0; $i <= 11; $i++) {
        $cnp_array[$i] = $key[$i] * $cnp[$i];
    }
    $precheck = array_sum($cnp_array) % 11;
    if ($precheck < 10) {
        $check = $precheck;
    } elseif ($precheck == 10) {
        $check = 1;
    }
    if ($key_control == $check) {
        return true;
    } else {
        return false;
    }

}

echo validare($cnp);

