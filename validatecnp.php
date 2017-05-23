<?php
/**
 * Created by PhpStorm.
 * User: ciure
 * Date: 4/24/2017
 * Time: 18:35
 */

include_once("functions.php");
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $function = $_POST['action'];
    return $function();
}
function add_user_data()
{
    global $conn;
    $sex = $_POST['sex'];
    $data_nasterii = $_POST['data_nasterii'];
    $varsta = $_POST['varsta'];
    $locul_nasterii = $_POST['locul_nasterii'];
    $cnp = $_POST['cnp'];

    if ($stmt = $conn->prepare("INSERT INTO user_data(sex, data_nasterii, varsta, locul_nasterii, cnp) VALUES (?,?,?,?,?)")) {
        $stmt->bind_param("ssdss", $sex, $data_nasterii, $varsta, $locul_nasterii, $cnp);
        $stmt->execute();
        echo $stmt->insert_id;
    } else {
        echo $stmt->error;
    }
}


function get_cnp_info()
{

    if (isset($_POST['cnp']) && !empty($_POST['cnp'])) {
        $cnp = $_POST['cnp'];
    }

    $sex = substr($cnp, 0, 1);
    $an = substr($cnp, 1, 2);
    $luna = substr($cnp, 3, 2);
    $zi = substr($cnp, 5, 2);
    $judet = substr($cnp, 7, 2);

    $barbat = array(1, 3, 5, 7);
    $femeie = array(2, 4, 6, 8);
    $imigrant = 9;


    // dimensiunea cnp ului
    if (strlen($cnp) != 13) {
        return 'CNP trebuie sa aiba 13 caractere';
    }

    // caracterele sunt cifre
    if (!is_numeric($cnp)) {
        return 'CNP trebuie sa contina numai cifre';
    }

    // definesc genul prin metoda needle-haystack
    switch ($sex) {
        case in_array($sex, $barbat):
            $gen = 'barbat';
            break;

        case in_array($sex, $femeie):
            $gen = 'femeie';
            break;

        case $sex == $imigrant:
            $gen = 'imigrant';
            break;
    }

    // definesc anul nasterii
    $anfull = '';
    switch ($sex) {
        case ($sex == 1 || $sex == 2):
            $anfull = '19' . $an;
            break;

        case ($sex == 3 || $sex == 4):
            $anfull = '18' . $an;
            break;

        case ($sex == 5 || $sex == 6):
            $anfull = '20' . $an;
            break;

        case ($sex == 7 || $sex == 8):
            $anfull = 'N/A';
            break;

    }
    // data nasterii
    $data_nasterii = $zi . '-' . $luna . '-' . $anfull;

    // validate date
    if (!checkdate($luna, $zi, $anfull) || !validare($cnp)) {
        return "CNP invalid";
    }

    setlocale(LC_TIME, 'ro_RO');
    $data_nasterii = date('Y-F-d', strtotime($data_nasterii));

    $date1 = date_create(date('Y-m-d', time()));
    $date2 = date_create(date('Y-m-d', strtotime($data_nasterii)));
    $varsta = date_diff($date1, $date2)->y;

    // stocare coduri pentru judete
    $jud = array(
        '01' => 'Alba', '02' => 'Arad',
        '03' => 'Arges', '04' => 'Bacau',
        '05' => 'Bihor', '06' => 'Bistrita-Nasaud',
        '07' => 'Botosani', '08' => 'Brasov',
        '09' => 'Braila', '10' => 'Buzau',
        '11' => 'Caras-Severin', '12' => 'Cluj',
        '13' => 'Constanta', '14' => 'Covasna',
        '15' => 'Dambovita', '16' => 'Dolj',
        '17' => 'Galati', '18' => 'Gorj',
        '19' => 'Harghita', '20' => 'Hunedoara',
        '21' => 'Ialomita', '22' => 'Iasi',
        '23' => 'Ilfov', '24' => 'Maramures',
        '25' => 'Mehedinti', '26' => 'Mures',
        '27' => 'Neamt', '28' => 'Olt',
        '29' => 'Prahova', '30' => 'Satu Mare',
        '31' => 'Salaj', '32' => 'Sibiu',
        '33' => 'Suceava', '34' => 'Teleorman',
        '35' => 'Timis', '36' => 'Tulcea',
        '37' => 'Vaslui', '38' => 'Valcea',
        '39' => 'Vrancea', '40' => 'Bucuresti',
        '41' => 'Bucuresti S.1', '42' => 'Bucuresti S.2',
        '43' => 'Bucuresti S.3', '44' => 'Bucuresti S.4',
        '45' => 'Bucuresti S.5', '46' => 'Bucuresti S.6',
        '51' => 'Calarasi', '52' => 'Giurgiu');

    // aflarea locului de nastere
    $locul_nasterii = '';
    foreach ($jud as $key => $value) {
        if ($judet == $key) {
            $locul_nasterii = $value;
        }
    }

    $ret = array(
        'sex' => $gen,
        'data_nasterii' => $data_nasterii,
        'varsta' => $varsta,
        'locul_nasterii' => $locul_nasterii
    );
    echo json_encode($ret);

}

function validare($cnp = '')
{
    if ($cnp = '') {
        $cnp = $_POST['cnp'];
    }
    echo $_POST['cnp'];die();
    $cnp = (string)$cnp;
    $key = str_split(279146358279);
    $key_control = $cnp[12];

    $cnp_array = array();

    for ($i = 0; $i <= 11; $i++) {
        $cnp_array[$i] = $key[$i] * $cnp[$i];
    }
    $check = array_sum($cnp_array) % 11;
    if ($check < 10) {
        $check = $check;
    } elseif ($check == 10) {
        $check = 1;
    }
    if ($key_control == $check) {
        return true;
    } else {
        return false;
    }
}






