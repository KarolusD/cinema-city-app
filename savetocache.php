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

$cinema_id = $_POST['cinema_id'] ?? CINEMA_KAZIMIERZ;
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

echo json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

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
                $sql= "INSERT INTO events (movie_id, name, cinema_id, time, data, booking_link, poster_link) VALUES ('" . $movie['id'] . "', '" . $movie['name'] . "', '".$cinema_id ."', " . $time . ",'".$date."','".$event['bookingLink']."', '".$movie['posterLink']."')";
                // echo $sql;die;
                $return[] = [
                    'movie_id' => $movie['id'],
                    'name' => $movie['name'],
                    'cinema_id' => $cinema_id,
                    'time' => $time,
                    'data' => $date,
                    'booking_link' => $event['bookingLink'],
                    'poster_link' => $movie['posterLink']
                ]; 
                $mysqli->query($sql);
               
            }
        }
    }
    $sql = "INSERT INTO cache_info (cinema_id, time, data) VALUES ('".$cinema_id."', '".time()."','".$date."')";
    $mysqli->query($sql);
    
    return $return;
  
}