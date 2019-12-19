<!DOCTYPE html>

<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Begrüßung</title>
    <LINK href="styles.css" rel="stylesheet" type="text/css">
</head>
<?php
session_start();
$_SESSION["id"] = $_POST["id"];
?>
<body>
<header>
    Herzlich Willkommen!
</header>
<div>
    Sobald Sie bereit sind Ihren Bewerbungstest zu starten, drücken sie auf START!<br>
    Die Zeit beginnt dann abzulaufen! <br>
    Viel Erfolg!
    <form method="get" action="Fragebogen.php">
        <input type="hidden" name="id"/>
        <button type="submit">Start</button>
    </form>
</div>
</body>
</html>