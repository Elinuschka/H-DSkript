<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fragebogen</title>
    <LINK href="styles.css" rel="stylesheet" type="text/css">
    <script language="javascript" type="text/javascript" src="js.js"></script>
    <script language="javascript" type="text/javascript" src="timer.js"></script>

</head>

<body>
<?php // Zeile 149 Pfad ändern  und durch aktuellen ersetzen!!!!!!
require_once 'Question.php';
require_once 'databaseConnection.php';
session_start();
$id = $_SESSION["id"];
$job = $_SESSION["job"];   // Bewerber-ID und Jobname in Variablen speichern
?>
<header>
    ID: <?php echo($id); ?>
</header>
<div class="zeit">
    <p id="timer"></p>
    <p style="display: none; color: red;" id="resttimer"></p>
</div>

<script type="text/javascript">
    setGesamtdauer(900); //zeit in sekunden angeben für dauer des tests
    startTimer();// timer starten bei 00:00
    runTimer();// resttimer startet bei gesamtdauer
</script>

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

        // Fragen sowie Antwortmöglichkeiten ausgeben
        $divcount1 = 0;
        foreach ($questions as $question) {
            $divcount1++;
            ?>
            <div id="tab_box_<?php echo $divcount1; ?>" class="tab_box"><?php
            $questionNum = array_search($question, $questions);
            echo '<h3>' . $question->getQuestion() . '</h3>';
            if ($question->getType() == 1) {
                foreach ($question->getAnswers() as $answer) {
                    echo '<input type="radio" name="question' . $questionNum . '" value="' . $answer . '">' . $answer . '</input><br>'; // Fragen mit radiobuttons
                }
            }
            if ($question->getType() == 2) {
                echo '<textarea rows="4" cols="50" name="textinput"></textarea><br>';   // fragen mit textinputfeld 
            }
            ?></div><?php
        }
        $divcount = 0;

        //navigation ausgeben für die fragen
        ?>
        <div class="menu">
            <div id="tabmenu" class="tabmenu"><?php
                for ($i = 0; $i < $maxAnswers; $i++) {
                    $divcount++;
                    ?>
                    <div id="tab_top_<?php echo $divcount; ?>" class="tab_top_active"
                         onclick=javascript:openTab(<?php echo $divcount; ?>)><?php echo $divcount; ?></div>
                    <div style="clear:both;"></div>
                    <?php
                }
                ?></div>
        </div><?php

        // Gegebene Antworten mit richtigen Antworten vergleichen und Resultat auswerten
       		$textQuestions = 0;
			$score = 0;
        $results = array();
        if (isset($_POST['submit'])) {
            foreach ($questions as $question) {
                $questionNum = array_search($question, $questions);
               
			if(!empty($_POST['question' . $questionNum])){  
				if ($question->getType() == 1 && $_POST['question' . $questionNum] == $question->getRightAnswer()) { //Frage richtig
						$score++;
						array_push($results, 'Frage: ' . $question->getQuestion() ."\n".
                        			'Antwort: ' . $_POST['question' . $questionNum] ."\n".'Richtig!' . "\n");
						
					} else if ($question->getType() == 1 && $_POST['question' . $questionNum] != $question->getRightAnswer()) { //Frage falsch
						array_push($results, 'Frage: ' . $question->getQuestion() . "\n".
                       				 'Antwort: ' . $_POST['question' . $questionNum] ."\n".'Falsch!' . "\n");
						
                }
            }else{
				if ($question->getType() == 2){		// Frage mit Eingabefeld 
					$textQuestions++;
					array_push($results, 'Frage: ' . $question->getQuestion() . "\n".
				'Antwort: ' . $_POST['textinput'] ."\n". 'Nicht geprüft!'. "\n");	//Post_textinput = text des Bewerbers
				
				}
				else{
				array_push($results, 'Frage: ' . $question->getQuestion() . "\n".  	// keine Antwort angegeben
                        'Antwort:' .'---keine Angabe---'."\n".'Falsch!' . "\n");
						}
			}}
			 $_SESSION["textQuestions"] = $textQuestions;
            $_SESSION["score"] = $score;
            $_SESSION["results"] = $results;
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/H&D/Ergebnis.php';  //URL herausfinden und weiterleiten an ErgebnisSeite
            echo("<script>location.href = '$url ';</script>");            // PFAD ÄNDERN!!!  wechselt die Seite auf Knopfdruck und Zeitablauf
        }
        echo '<button type="submit" name="submit" id="absenden"> Absenden </button>';
        $pdo = null;
        echo '</form>';
        ?>
</section>

<script type="text/javascript">
    openTab(1); //Tab 1 öffnen
</script>
</body>
</html>