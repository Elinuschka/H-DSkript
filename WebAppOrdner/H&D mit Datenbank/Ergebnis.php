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
<h3>Ihr Ergebnis:</h3>

<?php
session_start();
$score = $_SESSION["score"];
$results = $_SESSION["results"];
$maxAnswers = count($results);
$scorePercentage = $score / $maxAnswers * 100;

foreach ($results as $result) {
    echo $result;
    echo '<br><br>';
}

echo '<h4>Sie haben ' . $score . ' von ' . $maxAnswers . ' Fragen richtig beantwortet.';
echo '<br> Das entspricht ' . $scorePercentage . '%.</h4>';
?>

</body>
</html>
