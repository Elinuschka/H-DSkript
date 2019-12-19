<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ergebnis</title>
</head>
<body>
<header>
    <h2>Bewerbung Ende</h2>
</header>
<h3>Ihre Antworten wurden ausgwertet und versendet. Vielen Dank für Ihre Teilnahme!</h3><br>


<?php
session_start();
$job = $_SESSION["job"];
$id = $_SESSION["id"];
$score = $_SESSION["score"];
$results = $_SESSION["results"];
$to = 'nobody@example.com';
$subject = $id;
$message = " ID: " . $id . "\n Stelle: " . $job . "\n\n Ergebnis: \n";
$maxAnswers = count($results);
$scorePercentage = $score / $maxAnswers * 100;
foreach ($results as $result) {
    $message .= $result;
    $message .= "\n";
}

$message .= "\n \n   Der Bewerber hat " . $score . " von " . $maxAnswers . " Fragen richtig beantwortet.";
$message .= "\n   Das entspricht " . $scorePercentage . "%\n";


mail($to, $subject, $message);
?>

</body>
</html>