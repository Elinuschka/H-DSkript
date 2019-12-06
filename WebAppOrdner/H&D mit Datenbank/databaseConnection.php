<?php

// Connect to a MySQL database and create a PDO Object
function db_connect() {
    $dsn = 'mysql:host=localhost;dbname=cas;charset=utf8';
    $user = 'root';
    $password = '';
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    return new PDO($dsn, $user, $password, $opt);
}

// jobID abrufen
function getJobID ($jobName, $pdo) {
    $jobID = $pdo->query("SELECT ID FROM jobs WHERE name = '" . $jobName . "';")->fetchAll();
    foreach ($jobID as $row) {
        return $row['ID'];
    }
}

function getCategorieIDs ($jobID, $pdo) {
    $kategorieString = '';
    $kategorieIDs = $pdo->query("SELECT kategorieID FROM jobkategorie WHERE jobID = '" . $jobID . "'")->fetchAll();
    foreach ($kategorieIDs as $subArray) {
        foreach ($subArray as $ID) {
            $kategorieString = $kategorieString . $ID . ", ";
        }
    }
    return rtrim($kategorieString, ", ");
}
?>
