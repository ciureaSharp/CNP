<?php
/**
 * Created by PhpStorm.
 * User: ciure
 * Date: 4/24/2017
 * Time: 18:35
 */
//include ('index.php');

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
        '03' => 'Argeș', '04' => 'Bacău',
        '05' => 'Bihor', '06' => 'Bistrița-Năsăud',
        '07' => 'Botoșani', '08' => 'Brașov',
        '09' => 'Brăila', '10' => 'Buzău',
        '11' => 'Caraș-Severin', '12' => 'Cluj',
        '13' => 'Constanța', '14' => 'Covasna',
        '15' => 'Dâmbovița', '16' => 'Dolj',
        '17' => 'Galați', '18' => 'Gorj',
        '19' => 'Harghita', '20' => 'Hunedoara',
        '21' => 'Ialomița', '22' => 'Iași',
        '23' => 'Ilfov', '24' => 'Maramureș',
        '25' => 'Mehedinți', '26' => 'Mureș',
        '27' => 'Neamț', '28' => 'Olt',
        '29' => 'Prahova', '30' => 'Satu Mare',
        '31' => 'Sălaj', '32' => 'Sibiu',
        '33' => 'Suceava', '34' => 'Teleorman',
        '35' => 'Timiș', '36' => 'Tulcea',
        '37' => 'Vaslui', '38' => 'Vâlcea',
        '39' => 'Vrancea', '40' => 'București',
        '41' => 'București S.1', '42' => 'București S.2',
        '43' => 'București S.3', '44' => 'București S.4',
        '45' => 'București S.5', '46' => 'București S.6',
        '51' => 'Călărași', '52' => 'Giurgiu');

    // aflarea locului de nastere
    $locul_nasterii = '';
    foreach ($jud as $key => $value) {
        if ($judet == $key) {
            $locul_nasterii = $value;
        }
    }

    $ret = array(
        'sex' => $gen,
        'data nasterii' => $data_nasterii,
        'varsta' => $varsta,
        'locul nasterii' => $locul_nasterii
    );

    echo json_encode($ret);
}

function validare($cnp)
{

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

var_dump(get_cnp_info());




