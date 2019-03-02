<?php
function objectToArray($d)
{
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
         * Return array converted to object
         * Using __FUNCTION__ (Magic constant)
         * for recursive call
         */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}
function version($a){
	$rs = "";
	if(in_array('2d', $a)){
		$rs .= " 2D ";
	}
	else if(in_array('3d', $a)){
		$rs .= " 2D ";
	}
	else {
		var_dump($a);
	}
	if(in_array('dubbed', $a)){
		$rs .= "<span class='blue'>Dubbing</span>";
	}
	else if(in_array('subbed', $a)){
		$rs .= "<span class='green'>Z napisami</span>";
	}
	else if(in_array('local-language', $a) || in_array('original-lang-pl', $a)){
		$rs .= "<span class='red'>Po polsku</span>";
	}
	else{
		var_dump($a);
	}
	

	return $rs;
}
const CINEMA_KAZIMIERZ = 1076;
const CINEMA_PLAZA = 1063;
const CINEMA_ZAKOPIANKA = 1064;
const CINEMA_BONARKA = 1090;

// $aCinemas = [
//     "Kazimierz" => CINEMA_KAZIMIERZ, 
//     "Plaza" => CINEMA_PLAZA,
//     "Zakopianka" => CINEMA_ZAKOPIANKA,
//     "Bonarka" => CINEMA_BONARKA
// ];

require_once ('./db.php');

$cinema_id = $_POST['cinema'] ?? CINEMA_KAZIMIERZ;
$date = $_POST['date'] ?? date("Y-m-d");
$sql = "SELECT * FROM cache_info WHERE cinema_id = $cinema_id AND data = '$date'";
//  echo $sql;die;
$result = $mysqli->query($sql);
$return = [];

if($result->num_rows === 0){
   $return = parseCinemaResponse($cinema_id, $date, $mysqli);
  
}else{
   $row = mysqli_fetch_array($result);
   if(time() - intval($row['time']) > 60 * 60 * 12){
        $sql = "DELETE FROM cache_info WHERE cinema_id = $cinema_id AND data = '$date'";
        $mysqli->query($sql);
        $sql = "DELETE FROM events WHERE cinema_id = $cinema_id AND data = '$date'";
        $mysqli->query($sql);
        $return = parseCinemaResponse($cinema_id, $date, $mysqli);
   } else{
        $sql = "SELECT * FROM events WHERE cinema_id = $cinema_id AND data = '$date'";
        $result = $mysqli->query($sql);
        while ($erow = $result->fetch_assoc()) {
            $return[] = $erow;
        }
      
   }
       
}
$i = 0;
$helper = [];
foreach($return as $event){
	if(!in_array($event['name'], $helper)){
		//array_push($helper, $event['name']);
		$helper[] = $event['name'];
	}
}
foreach($helper as $movieName){
		echo "<h3>".$movieName."</h3><br/>";
	foreach($return as $event){
		if($event['name'] == $movieName){
			$ending = date("H:i", strtotime($event['time']) + ($event['length'] + 20 ) * 60);
			?>
			<div class='tile'>
				<div class='row full'>
				<a class='hover' target='_blank' href='https://www.cinema-city.pl<?= $event['bookingLink']?>'>
				od <strong> <?= date("H:i", strtotime($event['time'])) ?></strong> do <strong><?= $ending ?> </strong> - <?= version(json_decode($event['attributeIds'])) ?> 
				</a>
				</div>
			</div>
		
	<?php 

}
}
}



//echo json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

function parseCinemaResponse($cinema_id, $date, $mysqli){
    $return = [];
    $movies = 'https://www.cinema-city.pl/pl/data-api-service/v1/quickbook/10103/film-events/in-cinema/' . $cinema_id . '/at-date/' . $date . '?attr=&lang=pl_PL';
    $oMovies = json_decode(json_encode(json_decode(file_get_contents($movies))));
    $oMovies = objectToArray($oMovies);
    $aMovies = $oMovies['body']['films'];
    $aEvents = $oMovies['body']['events'];


    $helperArr = [];
    $flag = true;
    $aEventsHelper = [];
    foreach ($aEvents as $event) {
        foreach ($aMovies as $movie) {
            if ($event['filmId'] == $movie['id']) {
                $helperArr[$event['filmId']] = [$movie['name'], $movie['length']];
                $time = strtotime($event['eventDateTime']);
				$sql='';
                $sql= "INSERT INTO events (movie_id, name, cinema_id, time, data, booking_link, poster_link, length, attributeIds) VALUES ('" . $movie['id'] . "', '" . $movie['name'] . "', '".$cinema_id ."', " . $time . ",'".$date."','".$event['bookingLink']."', '".$movie['posterLink']."', '".$movie['length']."', '".json_encode($movie['attributeIds'])."')";
                // echo $sql;die;
				//var_dump($sql);
                $return[] = [
                    'movie_id' => $movie['id'],
                    'name' => $movie['name'],
                    'cinema_id' => $cinema_id,
                    'time' => $time,
                    'data' => $date,
                    'booking_link' => $event['bookingLink'],
                    'poster_link' => $movie['posterLink'],
					'length' => $movie['length'],
					'attributeIds' => json_encode($movie['attributeIds'])
                ]; 
                $mysqli->query($sql);
               
            }
        }
    }
    $sql = "INSERT INTO cache_info (cinema_id, time, data) VALUES ('".$cinema_id."', '".time()."','".$date."')";
    $mysqli->query($sql);
    
    return $return;
  
}