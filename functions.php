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
    if ($stmt = $conn->prepare('SELECT id, sex , data_nasterii, varsta, locul_nasterii, cnp, `timestamp` FROM user_data')) {
        $stmt->execute();
        $stmt->bind_result($id, $sex, $data_nasterii, $varsta, $locul_nasterii, $cnp, $timestamp);
        $stmt->store_result();
        $i = 0;
        while ($stmt->fetch()) {
            $ret[$i]['id'] = $id;
            $ret[$i]['sex'] = $sex;
            $ret[$i]['data_nasterii'] = $data_nasterii;
            $ret[$i]['varsta'] = $varsta;
            $ret[$i]['locul_nasterii'] = $locul_nasterii;
            $ret[$i]['cnp'] = $cnp;
            $ret[$i]['timestamp'] = $timestamp;
            $i++;
        }
        return $ret;
    } else {
        return $conn->error;
    }
}

function delete_users(){
    $ids = $_POST['id_delete'];
    var_dump($ids);die();
    global $conn;
    if($stmt = $conn->prepare('DELETE FROM user_data WHERE id IN(?)')){
        $stmt->bind_param('s', $ids);
        $stmt->execute();
        return 'OK';
    } else {
        return $conn->error;
    }
}