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

// type of movie [2d, 3d]
function typeOfMovie($a)
{
    $type = null;

    if (!in_array('3d', $a)) {
        $type = "2D";
    } else if (in_array('4dx', $a)) {
        $type = "4DX 3D";
    } else if (in_array('3d', $a)) {
        $type = "3D";
    }
    if (in_array('vip', $a)) {
        $type = 'VIP ' . $type;
    }

    return $type;
}

function langVersion($a, $movie)
{
    $lang = null;
    // echo '<h2>' . $movie . '</h2>';
    // echo '<pre>';
    // var_dump($a);
    // echo '</pre>';

    if (in_array('dubbed', $a)) {
        $lang = "Dubbing";
    } else if (in_array('subbed', $a)) {
        $lang = "Z napisami";
    } else if (in_array('local-language', $a) || in_array('original-lang-pl', $a)) {
        $lang = "Po polsku";
    }
    //array_push($rs, $image, $lang);

    return $lang;
}

// filter movies by current filter
function filterMovies($filterVal, $movieType)
{
    return $filterVal == $movieType;
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

require_once('./db.php');

$cinema_id = $_POST['cinema'] ?? CINEMA_BONARKA;
// $date = $_POST['date'] ?? date("d-m-Y");
$date = $_POST['date'] ?? '13-05-2019';
$date = date("Y-m-d", strtotime($date));
$filter = $_POST['filter'] ?? 'Wszystkie';


$sql = "SELECT * FROM cache_info WHERE cinema_id = $cinema_id AND data = '$date'";


//  echo $sql;die;
$result = $mysqli->query($sql);
$return = [];

if ($result->num_rows === 0) {
    // echo 'no cache<br/>';
    $return = parseCinemaResponse($cinema_id, $date, $mysqli);
} else {
    $row = mysqli_fetch_array($result);
    if (time() - intval($row['time']) > 60 * 60 * 12) {
        // echo 'old cache<br/>';
        $sql = "DELETE FROM cache_info WHERE cinema_id = $cinema_id AND data = '$date'";
        $mysqli->query($sql);
        $sql = "DELETE FROM events WHERE cinema_id = $cinema_id AND data = '$date'";
        $mysqli->query($sql);
        $return = parseCinemaResponse($cinema_id, $date, $mysqli);
    } else {
        // echo 'somecache<br/>';
        $sql = "SELECT * FROM events WHERE cinema_id = $cinema_id AND data = '$date'";
        $result = $mysqli->query($sql);
        while ($erow = $result->fetch_assoc()) {
            $return[] = $erow;
        }
    }
}
$i = 0;

function ajaxReturn($return, $filter)
{
    $ajax = [];

    foreach ($return as $event) {
        //print_r($event);
        // check if movie_type(2D, 3D) is the same as selected filter
        if ($filter === $event['movie_type'] || $filter === $event['language'] || $filter === 'Wszystkie') {
            // check if movie is played more then once
            if (!in_array($event['name'], array_column($ajax, 'name'))) {
                $ajax[$event['name']] = [
                    'movie_id' => $event['movie_id'],
                    'name' => $event['name'],
                    'cinema_id' => $event['cinema_id'],
                    'showtime' => array(
                        array(
                            'time' => date("H:i", $event['time']),
                            'booking_link' => $event['booking_link'],
                            'movie_type' => $event['movie_type']
                        )
                    ),
                    'data' => $event['data'],
                    'poster_link' => $event['poster_link'],
                    'length' => $event['length'],
                ];
            } else {
                // if it is, push only playtime hour, booking link and attribute Ids
                // repeated movie
                $repeatedMN = $event['name'];
                array_push($ajax[$repeatedMN]['showtime'], [
                    'time' => date("H:i", $event['time']),
                    'booking_link' => $event['booking_link'],
                    'movie_type' => $event['movie_type']
                ]);
            }
        }
    }
    // print_r($ajax);
    return $ajax;
}
//print_r(ajaxReturn(parseCinemaResponse($cinema_id, $date, $mysqli)));
// $ajaxFinal = ajaxReturn(parseCinemaResponse($cinema_id, $date, $mysqli), $filter);
$ajaxFinal = ajaxReturn($return, $filter);
echo json_encode($ajaxFinal, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

function parseCinemaResponse($cinema_id, $date, $mysqli)
{
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
            // echo "<pre>";
            // var_dump($movie);
            // echo "</pre>";
            if ($event['filmId'] == $movie['id']) {
                // echo "<pre>";
                // var_dump($event);
                // echo "</pre>";
                $helperArr[$event['filmId']] = [$movie['name'], $movie['length']];
                $time = strtotime($event['eventDateTime']);
                $sql = '';
                $sql = "INSERT INTO events (
                            movie_id, 
                            name,
                            cinema_id, 
                            time, 
                            data, 
                            booking_link, 
                            poster_link, 
                            length, 
                            movie_type,
                            language
                            ) VALUES (
                                '" . $movie['id'] . "', 
                                '" . $movie['name'] . "', 
                                '" . $cinema_id . "', 
                                " . $time . ",
                                '" . $date . "',
                                '" . $event['bookingLink'] . "', 
                                '" . $movie['posterLink'] . "', 
                                '" . $movie['length'] . "', 
                                '" . typeOfMovie($event['attributeIds']) . "',
                                '" . langVersion($event['attributeIds'], $movie['name']) . "')";
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
                    'movie_type' => typeOfMovie($event['attributeIds']),
                    'language' => langVersion($event['attributeIds'], $movie['name'])
                ];
                //print_r($return);
                $mysqli->query($sql);
            }
        }
    }
    $sql = "INSERT INTO cache_info (cinema_id, time, data) VALUES ('" . $cinema_id . "', '" . time() . "','" . $date . "')";
    // echo $sql;
    $mysqli->query($sql);
    // $c = array_filter($return, function($filter){
    //      return $filter == '2D';
    // });

    return $return;
}
