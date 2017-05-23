<?php
/**
 * Created by PhpStorm.
 * User: ciurea
 * Date: 5/11/2017
 * Time: 18:42
 */
// Initializam mysqli si declaram global
$conn = new mysqli('127.0.0.1', 'digitala_gabi', '133admin133!', 'digitala_dl_gabi');
global $conn;

// Scoatem din baza de date userii, introducem in array ul $ret un array pentru fiecare set de rezultate ($i = iteratie pentru fiecare set)
function get_users()
{
    global $conn;
    $ret = array();
    if ($stmt = $conn->prepare('SELECT id, sex , data_nasterii, varsta, locul_nasterii, cnp, `timestamp` FROM user_data ORDER BY id DESC')) {
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

// Stergem randurile cu id urile venite prin post; transformam array ul $_POST['id_delete'] intr un string
// $_POST['id_delete'] vine prin ajax din index.php (confirmare stergere)
function delete_users()
{
    $ids = implode(',', $_POST['id_delete']);
    global $conn;
    if ($stmt = $conn->prepare('DELETE FROM user_data WHERE id IN(' . $ids . ')')) {
        $stmt->execute();
        $ret = $stmt->affected_rows;
        echo $ret;
    } else {
        echo $conn->error;
    }
}