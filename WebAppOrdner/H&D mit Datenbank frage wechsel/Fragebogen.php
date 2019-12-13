<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fragebogen</title>
    <LINK href="styles.css" rel="stylesheet" type="text/css">
    <script language="javascript" type="text/javascript" src="js.js"></script>

</head>
<!--
<header>
    <script type="text/javascript">
        function openTab(index) {
            var element = document.getElementsByTagName('div');
            var name = "";
            var obj;

            for (var i = 0; i < element.length; i++) {
                name = element[i].id;
                if (name.substr(0, 8) == 'tab_box_') {
                    obj = document.getElementById(name);

                    obj.hidden = true;

                }
                if (name.substr(0, 8) == 'tab_top_') {
                    obj = document.getElementById(name);
                    obj.setAttribute('class', 'tab_top_passive');
                }

            }
            var tab = document.getElementById("tab_box_" + index);
            tab.hidden = false;
            tab = document.getElementById("tab_top_" + index);
            tab.setAttribute('class', 'tab_top_active');

        }
    </script>
</header>
-->
<body>
<?php
require_once 'Question.php';
require_once 'databaseConnection.php';

session_start();
$_SESSION["id"] = $_GET["id"];
$id = $_SESSION["id"];
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
            for ($i = 1; $i <= $maxAnswers; $i++) {
                $currentAnswer = $row['antwort' . $i];
                if ($currentAnswer == null || $currentAnswer = '') {
                    continue;
                }
                $question->addAnswer($row['antwort' . $i]);
            }
            array_push($questions, $question);
        }

        $divcount1 = 0;
        foreach ($questions as $question) {
            $divcount1++;
            ?>
            <div id="tab_box_<?php echo $divcount1; ?>" class="tab_box"><?php
            $questionNum = array_search($question, $questions);
            echo '<h3>' . $question->getQuestion() . '</h3>';
            if ($question->getType() == 1) {
                foreach ($question->getAnswers() as $answer) {
                    echo '<input type="radio" name="question' . $questionNum . '" value="' . $answer . '">' . $answer . '</input><br>';
                }
            }
            if ($question->getType() == 2) {
                echo '<textarea rows="4" cols="50" name="question' . $questionNum . '" form="usrform"></textarea><br>';
            }
            ?></div><?php
        }

        $divcount = 0;
        // Fragen sowie Antwortmöglichkeiten ausgeben
        ?>
        <div class="menu"><div id="tabmenu" class="tabmenu"><?php
            for($i=0; $i < $maxAnswers; $i++) {
                $divcount++;
                ?>
                <div id="tab_top_<?php echo $divcount; ?>" class="tab_top_active"
                     onclick=javascript:openTab(<?php echo $divcount; ?>)><?php echo $divcount; ?></div>
                <div style="clear:both;"></div>
                <?php
                /*
                    $questionNum = array_search($question, $questions);
                echo '<h3>' . $question->getQuestion() . '</h3>';
                if ($question->getType() == 1) {
                    foreach ($question->getAnswers() as $answer) {
                        echo '<input type="radio" name="question' . $questionNum . '" value="' . $answer . '">' . $answer . '</input><br>';
                    }
                }
                if ($question->getType() == 2) {
                    echo '<textarea rows="4" cols="50" name="question' . $questionNum . '" form="usrform"></textarea><br>';
                }
                */

                /*echo '<br>';*/
            }
            ?></div></div><?php

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
                } else if ($question->getType() == 1 && $_POST['question' . $questionNum] != $question->getRightAnswer()) {
                    array_push($results, 'Frage: ' . $question->getQuestion() .
                        '<br> Antwort: ' . $_POST['question' . $questionNum] . '<br> Falsch! ');
                }
            }
            $_SESSION["score"] = $score;
            $_SESSION["results"] = $results;
            header('location:Ergebnis.php');
        }

        echo '<button type="submit" name="submit" value="' . $id . '" > Absenden </button>';
        $pdo = null;
        echo '</form>';
        ?>
</section>

<script type="text/javascript">
    openTab(1); //Tab 1 öffnen
</script>
</body>
</html>
