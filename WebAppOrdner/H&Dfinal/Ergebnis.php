<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ergebnis</title>
</head>
<body>
<header>
    <h2>Test-Ende</h2>
</header>
<h3>Sie haben den Test beendet. <br>Ihre Antworten wurden ausgwertet und versendet. <br><br>Vielen Dank für Ihre Teilnahme!</h3><br>


<?php
session_start();	//alle Werte aus der Session abrufen 
$job = $_SESSION["job"];
$id = $_SESSION["id"];
$score = $_SESSION["score"];
$results = $_SESSION["results"];
$textQuestions = $_SESSION["textQuestions"];	// Anzahl der Fragen die ein Texteingabefeld beinhalten
$to = 'nobody@example.com';			// Ziel-Email-Adresse
$subject = $id;					// Bewerber ID als Betreff 
$message = " ID: ". $id ."\n Stelle: ". $job. "\n\n Ergebnis: \n \n";
$maxAnswers = count($results);
$maxAnswers = $maxAnswers - $textQuestions;
$scorePercentage = $score / $maxAnswers * 100;
	foreach ($results as $result) {		//gibt Fragen mit Antworten wieder
    $message .=  $result;
    $message .= "\n";
}
				
$message .= "\n \n   Der Bewerber hat " . $score . " von " . $maxAnswers . " Fragen richtig beantwortet.";  //gibt Ergebnis wieder
$message .= "\n   Das entspricht " . $scorePercentage . "%\n";
$message .= "\n" . $textQuestions . " von den Fragen sind Textfragen, die nicht auf Korrektheit geprüft werden können. \n Diese gehen nicht in die Wertung ein.\n";

mail($to, $subject, $message);			// sendet E-Mail
?>

</body>
</html>