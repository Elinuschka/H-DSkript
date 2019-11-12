<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ID Eingabe</title>
    <LINK href="styles.css" rel="stylesheet" type="text/css">
</head>

<?php
    session_start();
$_SESSION["job"]=$_POST["sent"];
?>

<body>
<header>
    <p style="font-family: Bahnschrift SemiBold">H&D  </p>
</header>
<p style="font-family: Bahnschrift SemiBold">
<?php
echo $_POST["sent"];
?></p>
<div style="margin: 50px">
    <form method="get" action="Fragebogen.php">
        ID:
        <input type="text" name="id" />
        <button type="submit" name="job" > Absenden </button>
    </form>


</div>


</body>
</html>