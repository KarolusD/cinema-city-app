<?php 
const CINEMA_KAZIMIERZ = 1076;
const CINEMA_PLAZA = 1063;
const CINEMA_ZAKOPIANKA = 1064;
const CINEMA_BONARKA = 1090;
$aCinemas = [
	"Kazimierz" => CINEMA_KAZIMIERZ,
	"Plaza" => CINEMA_PLAZA,
	"Zakopianka" => CINEMA_ZAKOPIANKA,
	"Bonarka" => CINEMA_BONARKA,
];
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&amp;subset=latin-ext" rel="stylesheet">
<link rel="stylesheet" href="./css/style.css">

</head>
<body>
<div class="container">
<form>
<input id='dateInput' type='date' name='date' value="<?=date("Y-m-d")?>"'>
<br/>
<select id="cinemaSelect" type='select' name='cinema' >
<?php foreach($aCinemas as $k => $c) : ?>
	<option value="<?=$c?>" ><?=$k?></option>
<?php endforeach;?>
</select><br/>
</form>
<div id ='movieList'>
</div>
</div>
<script src="app.js?v=<?= date("ymsd") ?>"></script>
</body>
</html>