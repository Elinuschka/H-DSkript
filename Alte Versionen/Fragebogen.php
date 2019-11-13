<!DOCTYPE html>
	<html lang="en">
		<head>
    		<meta charset="UTF-8">
    			<title>Fragebogen</title>
    			<LINK href="styles.css" rel="stylesheet" type="text/css">
		</head>
<body>
<div>
    <header>
        <p>Test Java Softwareentwickler (m/w/d) </p>
        <img href="home.html"><img src="hd.png"/></img>
    </header>
 <section>
     <form action="" method="post">  
	
<?php
	$rightAnswers=0;
	$datei = "Fragen.txt";						 // Name der Datei
	$komplett = file_get_contents($datei); 				// Datei in string
	$str_arr = explode ("§", $komplett); 				 //fragen mit antworten in str_arr
	$max = sizeof($str_arr);					//anzahl elemente in str_arr
	$fragAntw[] = array();
	for($i = 0; $i < $max;$i++){					//str_arr durchlaufen
	$str_arr2 = explode ("$", $str_arr[$i]);			 //jedes str_arr element teilen 
	$fragMax = sizeof($str_arr2);					//max für jede frage
	for($j = 0; $j < $fragMax;$j++){
		$fragAntw[$i][$j]= $str_arr2[$j];
		if($j==0){								//Fragen extra trennen bzw ausgeben wenn es erstes element in array
?>
	<h3>Frage  <?php echo  $i+1; print_r( $fragAntw[$i][0]); ?>  </h3>	
		<fieldset>
<?php	
	}else{										//sonst anwort checkboxen erstellen 
	$answer_arr = explode(";", $fragAntw[$i][$j]);					// richtig falsch von antwort trennen   
?>
	<ul>
             <li>
  		<label>				
<?php   	
	if($answer_arr[1]=="r")									//r oder f als value   antwort als name ?????????
	{ $rightAnswers++;?>
		<input type="checkbox" name="allAnswers[]" value="r">
<?php 
}else{ ?>
		<input type="checkbox" name="allAnswers[]" value="f">
<?php }											// in array namen vergeben  das array danach abfragen
                           
	print_r($answer_arr[0]); ?>
        	</label>
                	 </li>
               			 </ul>
<?php 
	}										//Ende if
		}
?> 
	</fieldset>
<?php 											// Ende for j
}											// Ende for i
?> 
 </section>
	<footer>
		<form method="post" action="Fragebogen.php">
		<input type="submit" name="sent">
			</form>
    				</footer>
<?php
	if(isset($_POST['sent'])){
		$answer = $_POST['allAnswers'];
  			if(empty($answer)){
  				echo("Sie haben keine Antworten angekreuzt");
			}else{
				$N = count($answer);
 				echo("Sie haben $N Antworten angekreuzt: ");
				$wertung =0;
					for($i=0; $i < $N; $i++){
						 echo($answer[$i] . " ");
							if($answer[$i]=="r"){
								$wertung++;
							}else{
							$wertung--;
							}
					}
				echo("Ihre Wertung: " . $wertung . " von möglichen " . $rightAnswers);
				}
			}
?>
			</form>
		</div>
	</body>
</html>