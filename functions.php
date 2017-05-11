<?php
/**
 * Created by PhpStorm.
 * User: ciure
 * Date: 5/11/2017
 * Time: 18:42
 */
$conn = new mysqli('127.0.0.1', 'digitala_gabi', '133admin133!', 'digitala_dl_gabi');
global $conn;

function get_users()
{
    global $conn;
    if ($stmt = $conn->prepare('SELECT * FROM user_data')) {
        $stmt->execute();
        $stmt->bind_result($id, $data_nasterii, $varsta, $locul_nasterii, $cnp, $timestamp);
        $stmt->store_result();
        while ($stmt->fetch()) {
            $ret[] = array($id, $data_nasterii, $varsta, $locul_nasterii, $cnp, $timestamp);
        }
        return $ret;
    } else {
        return $conn->error;
    }
}