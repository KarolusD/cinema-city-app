<?php
$host = '127.0.0.1';
$username = 'root';
$pass = '';
$dbname = 'cinema_city';
$mysqli = new mysqli($host, $username, $pass, $dbname);

    /* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
else {
// echo("connection succesfull with db" . "<br/>");
}
$mysqli->set_charset("utf8");