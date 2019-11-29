<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fragebogen</title>
    <LINK href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
session_start();
$_SESSION["id"] = $_GET["id"];
$idCandidate = $_SESSION["id"];
$job = $_SESSION["job"];
?>
<header>
    ID: <?php echo($_SESSION["id"]); ?>
</header>

<section>
    <form action="" method="post">
        <?php
        $rightAnswers = 0;                            //2394204320843208348032vorher einfi
        $datei = $job . ".txt";                         // Name der Datei
        $komplett = file_get_contents($datei);                // Datei in string
        $str_arr = explode("§", $komplett);                 //fragen mit antworten in str_arr
        $max = sizeof($str_arr);                    //anzahl elemente in str_arr
        $fragAntw[] = array();
        for ($i = 0; $i < $max; $i++) {                    //str_arr durchlaufen
            $str_arr2 = explode("$", $str_arr[$i]);             //jedes str_arr element teilen
            $fragMax = sizeof($str_arr2) - 1;                    //max für jede frage
            for ($j = 0; $j < $fragMax; $j++) {
                $fragAntw[$i][$j] = $str_arr2[$j];
                if ($j == 0) {                                //Fragen extra trennen bzw ausgeben wenn es erstes element in array
                    ?>
                    <h3>Frage <?php echo $i + 1;
                        print_r($fragAntw[$i][0]); ?>  </h3>
                    <fieldset>
                    <?php
                } else {                                        //sonst anwort checkboxen erstellen
                    $answer_arr = explode(";", $fragAntw[$i][$j]);                    // richtig falsch von antwort trennen
                    ?>
                    <ul>
                        <li>
                            <label>

                                <?php
                                if ($answer_arr[1] == "r")                                    //r oder f als value   antwort als name ?????????
                                {
                                    $rightAnswers++; ?>
                                    <input type="checkbox" name="allAnswers[]" value="r">
                                    <?php
                                } else { ?>
                                    <input type="checkbox" name="allAnswers[]" value="f">
                                <?php }                                            // in array namen vergeben  das array danach abfragen
                                print_r($answer_arr[0]); ?>
                            </label>
                        </li>
                    </ul>
                    <?php
                }                                        //Ende if
            }
            ?>
            </fieldset>
            <?php // Ende for j
        }                                        // Ende for i
        ?>

</section>
</body>
<footer>
    <div>
        <form method="post" action="Ergebnis.php">
            <button type="submit" name="werte"> Absenden</button>


            <?php
            //if(isset($_POST['werte'])){					//Absicherung wenn keins angeklickt
            if (!empty($_POST['allAnswers'])) {
                $answer = $_POST['allAnswers'];
                if (empty($answer)) {
                    echo("Sie haben keine Antworten angekreuzt");
                } else {
                    $N = count($answer);
                    $wertung = 0;
                    for ($i = 0; $i < $N; $i++) {
                        if ($answer[$i] == "r") {
                            $wertung++;
                        } else {
                            $wertung--;
                        }
                    }
                    $resultPercent = ($wertung / $rightAnswers) * 100;
                    $to = 'nobody@example.com';
                    $subject = $idCandidate;
                    $message = 'ID: ' . $idCandidate . "\n" . 'Stelle: ' . $job . "\n" . 'Richtige Antworten: ' . $wertung . '/' . $rightAnswers . "\n" . 'in Prozent: ' . $resultPercent . '%';
                    mail($to, $subject, $message);
                }
                $url = 'http://' . $_SERVER['HTTP_HOST'] . '/H&D/Ergebnis.php';  //URL herausfinden und weiterleiten an ErgebnisSeite
                echo("<script>location.href = '$url . ?msg=$msg';</script>");
            }
            //}
            ?>
        </form>
    </div>
</footer>
</html>