<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fragebogen</title>
    <LINK href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
require_once 'Question.php';
require_once 'databaseConnection.php';

session_start();
$_SESSION["id"] = $_GET["id"];
$idCandidate = $_SESSION["id"];
$job = $_SESSION["job"];

?>
<header>
    ID: <?php echo($_SESSION["id"]); ?>
</header>

<section>
    <form action="Fragebogen.php" method="post">
        <?php

        // Datenbankverbindung herstellen
        try {
            $pdo = db_connect();
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }

        // Job ID abrufen
        $jobID = getJobID($job, $pdo);

        // Array mit Kategorie IDs erstellen anhand des Jobs
        $formattedCategorieIDs = getCategorieIDs($jobID, $pdo);

        // Anzahl Antwortmöglichkeiten
        $count = $pdo->prepare("SELECT * FROM fragen");
        $count->execute();
        $maxAnswers = $count->columnCount() - 5;

        // Select Statement für Jobspezifische Fragen
        $result = $pdo->query("SELECT * FROM fragen WHERE kategorieID IN (" . $formattedCategorieIDs . ")")->fetchAll();

        $questions = array();

        // Objekt mit Fragen, fragenTyp, richtiger Antwort sowie Antwortmöglichkeiten füllen
        foreach ($result as $row) {
            $question = new Question($row['frage'], $row['frageTyp'], array(), $row['richtigeAntwort']);
            for($i = 1; $i <= $maxAnswers; $i++) {
                $currentAnswer = $row['antwort'. $i];
                if($currentAnswer == null || $currentAnswer = '') {
                    continue;
                }
                $question->addAnswer($row['antwort'. $i]);
            }
            array_push($questions, $question);
        }

        // Fragen sowie Antwortmöglichkeiten ausgeben
        foreach ($questions as $question) {
            $questionNum = array_search($question, $questions);
            echo '<h3>' . $question->getQuestion() . '</h3>';
            if ($question->getType() == 1) {
                foreach($question->getAnswers() as $answer) {
                    echo '<input type="radio" name="question' . $questionNum . '" value="' . $answer . '">' . $answer . '</input><br>';
                }
            }
            if ($question->getType() == 2) {
                echo '<textarea rows="4" cols="50" name="question'. $questionNum .'" form="usrform"></textarea><br>';
            }
            echo '<br>';
        }

        // Gegebene Antworten mit richtigen Antworten vergleichen und Resultat auswerten
        $score = 0;
        $results = array();
        if (isset($_POST['submit'])) {
            foreach ($questions as $question) {
                $questionNum = array_search($question, $questions);
                if ($question->getType() == 1 && $_POST['question' . $questionNum] == $question->getRightAnswer()) {
                    $score++;
                    array_push($results, 'Frage: ' . $question->getQuestion() .
                        '<br> Antwort: ' . $_POST['question' . $questionNum] . '<br> Richtig! ');
                }
                else if ($question->getType() == 1 && $_POST['question' . $questionNum] != $question->getRightAnswer()) {
                    array_push($results, 'Frage: ' . $question->getQuestion() .
                        '<br> Antwort: ' . $_POST['question' . $questionNum] . '<br> Falsch! ');
                }
            }
            $_SESSION["score"] = $score;
            $_SESSION["results"] = $results;
            header('location:Ergebnis.php');
        }

        echo '<button type="submit" name="submit"> Absenden </button>';
        $pdo = null;
    echo '</form>';
    ?>
</section>
</body>
</html>
