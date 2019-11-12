<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>H&D Bewerbungsassystent</title>
  <LINK href="styles.css" rel="stylesheet" type="text/css">
</head>
<?php?>
<body>
<header>
<p style="font-family: Bahnschrift SemiBold">H&D</p>
</header>
<div style="margin: 50px">
  <div class="buttons" >
    <br class="abstand">
<?php
$datei="Stellen.txt";
$komplett = file_get_contents($datei); 				// Datei in string
	$str_arr = explode (";", $komplett); 				 //fragen mit antworten in str_arr
	$max = sizeof($str_arr)-1;

for($i =0; $i<$max;$i++){
?>
		<form method="post" action="id.php">
		<input type="submit" name="sent" value ="<?php echo($str_arr[$i]);?>">
	</form>
<?php } ?>


</body>
</html>