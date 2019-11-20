<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>H&D Bewerbungsassystent</title>
    <LINK href="styles.css" rel="stylesheet" type="text/css">
</head>
<? php ?>
<body>
<header>
    H&D
</header>

<select name="Stellen[]">
    <?php
    $datei = "Stellen.txt";
    $komplett = file_get_contents($datei);                // Datei in string
    $str_arr = explode(";", $komplett);                 //fragen mit antworten in str_arr
    $max = sizeof($str_arr) - 1;

    for ($i = 0; $i < $max; $i++) {
        ?>
        <form method="post" action="id.php">
            <option type="submit" name="sent" value="<?php echo($str_arr[$i]); ?>"><?php echo($str_arr[$i]); ?></option>
        </form>
    <?php } ?>
</select>
<form method="post" action="id.php">
<button type="submit" name="sent" value="<?php $_POST['Stellen'] ?>"><?php $_POST['Stellen'] ?></button>
</form>
<?php
if (isset($_POST['sent'])) {
    if (isset($_POST['Stellen'])) {
        foreach ($_POST['Stellen'] as $value) {
            $_POST["sent"] = $_POST['Stellen'];
        }
    }
}
?>


<?php
$datei = "Stellen.txt";
$komplett = file_get_contents($datei);                // Datei in string
$str_arr = explode(";", $komplett);                 //fragen mit antworten in str_arr
$max = sizeof($str_arr) - 1;

for ($i = 0; $i < $max; $i++) {
    ?>
    <form method="post" action="id.php">
        <button type="submit" name="sent" value="<?php echo($str_arr[$i]); ?>"><?php echo($str_arr[$i]); ?></button>
    </form>
<?php } ?>


</body>
</html>