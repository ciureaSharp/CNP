<?php
/**
 * Created by PhpStorm.
 * User: ciure
 * Date: 4/13/2017
 * Time: 21:19
 */

//1841108430125
$start_age = (integer)'-5364668664'; //unix timextamp pt. 1800-01-01
$fin_age = strtotime('now'); // unix timestamp pt acum
$unix_date = mt_rand($start_age, $fin_age); // random intre anterioarele
$human_date = date('Ymd', $unix_date); //$unix date transformat in data cu formatul necesar

$century = $human_date[0] . $human_date[1]; //primele 2 cifre din an

switch ($century) { //stabilim sexul in functie de anul nasterii
    case 19:
        $sex = $unix_date = mt_rand(1, 2);
        break;

    case 18:
        $sex = $unix_date = mt_rand(3, 4);
        break;
    case 20:
        $sex = $unix_date = mt_rand(5, 6);
        break;
}

$sex_data = $sex . substr($human_date, 2, 7); //inlocuim primele 2 cifre din an cu sexul
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

$judet = array_rand($jud); //luam un cod de judet random
$nnn = str_pad(mt_rand(001, 999), 3, '0', STR_PAD_LEFT); //whatever, go to wiki
$cnp_neverificat = $sex_data . $judet . $nnn; //concatenam smecheriile

$key = str_split(279146358279);

$cnp_array = array();

for ($i = 0; $i <= 11; $i++) {
    $cnp_array[$i] = $key[$i] * $cnp_neverificat[$i];
}

$check_rezult = array_sum($cnp_array) % 11;

if ($check_rezult < 10) {
    $check = $check_rezult;
} elseif ($check_rezult == 10) {
    $check = 1;
}

$cnp = $cnp_neverificat . $check; //magie!
echo $cnp;