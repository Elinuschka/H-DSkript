<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>H&D Bewerbungsassystent</title>
    <LINK href="styles.css" rel="stylesheet" type="text/css">
    <script language="javascript" type="text/javascript" src="js.js"></script>
</head>

<body>

<header>
    H&D
</header>

Wählen Sie die gewünschte Stelle aus!
<br>

<div class="dropdown">
    <button onclick="myFunction()" class="dropbtn">Stellenbezeichnung</button>
    <div id="myDropdown" class="dropdown-content">
        <input type="text" placeholder="Suche.." id="myInput" onkeyup="filterFunction()">
        <?php
        include_once 'databaseConnection.php';
        try {
            $pdo = db_connect();
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
        echo '<form method="post" action="id.php">';
        // Jobs aus der Datenbank auslesen
        $stmt = $pdo->query("SELECT * FROM jobs");
        while ($row = $stmt->fetch()) {
            echo '<button class="button1" type="submit" name="sent" value="' . $row['name'] . '">' . $row['name'] . '</button><br>';
        }
        echo '</form>';
        // Close Connection
        $pdo = null;
        ?>
    </div>

</div>
</body>
</html>