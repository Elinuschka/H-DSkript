<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ID Eingabe</title>
    <LINK href="styles.css" rel="stylesheet" type="text/css">
</head>

<?php
session_start();
$_SESSION["job"] = $_POST["sent"];
?>

<body>
<header>
<?php echo $_POST["sent"]; ?>
</header>
<div>
    <form method="get" action="Willkommen.php">
        <p>Bitte geben sie die Bewerber-ID ein</p>
        ID:
        <input type="text" name="id"/>
        <button type="submit" name="job"> Absenden</button>
    </form>
</div>
</body>
</html>