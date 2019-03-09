<?php 
$url = $_REQUEST['link'] . '&prsntId='. $_REQUEST['prsntId'];
header("Location: $url");