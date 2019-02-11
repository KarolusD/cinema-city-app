<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&amp;subset=latin-ext" rel="stylesheet">
<link rel="stylesheet" href="./css/style.css">

</head>
<body>
<div class="container">
<form action="" method="get">
<input type='date' name='date' value="<?=$date ? $date : date("Y-m-d")?>"'>
<br/>
<select id="select" type='select' name='cinema' >
<?php foreach($aCinemas as $k => $c) : ?>
	<option value="<?=$c?>" ><?=$k?></option>
<?php endforeach;?>
</select><br/>
<button type="submit">Sprawdź</button>
</form>
<?php
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
?>
</div>
<script src="app.js?v=<?= date("ymsd") ?>"></script>
</body>
</html>