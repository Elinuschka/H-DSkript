<!DOCTYPE html>

<html>
<head>
  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Begrüßung</title>
    <LINK href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    Herzlich Willkommen!
</header>
<div>
    Sobald Sie bereit sind Ihren Bewerbungstest zu starten, drücken sie auf START<br>
    Viel Erfolg!
    <form method="get" action="Fragebogen.php">
	<input type ="hidden"  name="id" value="<?php echo $_GET["id"]; ?>"/>
        <button type="submit">Start</button>
    </form>
</div>
</body>
</html>
