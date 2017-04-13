<?php 
	//1 89 04 06 03 527 9
//comment
	// rand gen
	$sex = mt_rand(1,6);
	$an = str_pad(mt_rand(00,99), 2, "0", STR_PAD_LEFT);
	$luna = str_pad(mt_rand(01, 12), 2, "0", STR_PAD_LEFT);
	$judet = str_pad(mt_rand(01, 52), 2, "0", STR_PAD_LEFT);
	$NNN = str_pad(mt_rand(001,999), 3, "0", STR_PAD_LEFT);
	$control = mt_rand(0,9);

	do {
		$judet = str_pad(mt_rand(01, 52), 2, "0", STR_PAD_LEFT);
	} while ($judet == 47 || $judet == 48 || $judet== 49 || $judet== 50);

	$barbat = array(1, 3, 5);
	$femeie = array(2, 4, 6);

	switch($sex){
		case in_array($sex, $barbat):
		$gen = 'Barbat';
		break;
		
		case in_array($sex, $femeie):
		$gen = 'Femeie';
		break;
	}

	// anul nasterii
	$anfull = '';
	switch($sex){
		case ($sex == 1 || $sex == 2):
		$anfull = '19' . $an;
		break;
		
		case ($sex == 3 || $sex == 4):
		$anfull = '18' . $an;
		break;	
	}

	if ($sex == 5 || $sex == 6){
		$an = str_pad(mt_rand(00,17), 2, "0", STR_PAD_LEFT);
		$anfull = '20' . $an;
	}

	$max_days = array(
			'01' => '31',
			'02' => '29',
			'03' => '31',
			'04' => '30',
			'05' => '31',
			'06' => '30',
			'07' => '31',
			'08' => '31',
			'09' => '30',
			'10' => '31',
			'11' => '30',
			'12' => '31',
		);
	foreach($max_days as $key => $value){
		if ($key = $luna){
			$zi = str_pad(mt_rand(01, $value), 2, "0", STR_PAD_LEFT);
		}
	}

	//data nasterii
	$data_nasterii = $zi .'-'. $luna .'-'. $anfull;


	// locul nasterii
	$jud = array(
		'01' =>	'Alba', '02' =>	'Arad',
		'03' => 'Argeș', '04' => 'Bacău',
		'05' =>	'Bihor', '06' => 'Bistrița-Năsăud',
		'07' =>	'Botoșani', '08' =>	'Brașov',		
		'09' =>	'Brăila', '10' => 'Buzău',		
		'11' =>	'Caraș-Severin', '12' => 'Cluj',		
		'13' =>	'Constanța', '14' => 'Covasna',		
		'15' =>	'Dâmbovița', '16' => 'Dolj',		
		'17' =>	'Galați', '18' => 'Gorj',		
		'19' =>	'Harghita', '20' =>	'Hunedoara',		
		'21' => 'Ialomița', '22' =>	'Iași',		 
		'23' =>	'Ilfov', '24' => 'Maramureș',		
		'25' =>	'Mehedinți', '26' => 'Mureș',		
		'27' =>	'Neamț', '28' => 'Olt',		
		'29' =>	'Prahova', '30' => 'Satu Mare',		
		'31' =>	'Sălaj', '32' => 'Sibiu',		
		'33' =>	'Suceava', '34' => 'Teleorman',		
		'35' =>	'Timiș', '36' => 'Tulcea',		
		'37' =>	'Vaslui', '38' => 'Vâlcea',
		'39' =>	'Vrancea', '40' => 'București',		
		'41' =>	'București S.1', '42' => 'București S.2',		
		'43' =>	'București S.3', '44' => 'București S.4',		
		'45' =>	'București S.5', '46' => 'București S.6',		
		'51' =>	'Călărași', '52' =>	'Giurgiu' );

	// aflarea locului de nastere
	$locul_nasterii ='';
	foreach($jud as $key => $value){
		if($judet == $key){
			$locul_nasterii = $value;
		}
	}


	// varsta
	$varsta = (int)date('Y') - (int)$anfull; 

	$cnp =  $sex . $an . $luna . $zi . $judet . $NNN . $control . "<br>";
	
// validare 
	$cnp = (string)$cnp;
	$key = str_split(279146358279);
	$control = $cnp[12];


	 $cnp_array = array();

		for($i = 0; $i <= 11; $i++){
 		$cnp_array[$i] = $key[$i] * $cnp[$i];
 			}
 		
 		$check = array_sum($cnp_array) % 11;
	 	
	 	if($check < 10){
	 		$check = $check;
	 	} elseif ($check == 10){
	 		$check = 1;
	 	}
		
		$control == $check;
	
	// checkdate($luna, $zi, $anfull);
	// var_dump(checkdate($luna, $zi, $anfull));
			
	echo $cnp;
	echo "genul: " . $gen . "<br>";
	echo "data nasterii: " . $data_nasterii . "<br>";
	echo "locul nasterii: " . $locul_nasterii . "<br>";
	echo "varsta: " . $varsta . "<br>";

	if ($varsta > 110){
		echo 'Decedat';
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Random CNP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
	<body>

		<form action="index.php" method="post">
			<input type="submit" class="btn btn-primary" value="Back" name="Back">
		</form> 

	</body>
</html>