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
    } else {
        echo 'goog';
    }

    // caracterele sunt cifre
    if (!is_numeric($cnp)) {
        return 'CNP trebuie sa contina numai cifre';
        exit;
    } else {
        echo 'is good';
    }



