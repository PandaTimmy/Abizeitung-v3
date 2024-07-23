<?php

header('Content-Type: text/html; charset=utf-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// import databaseconfiguration
require_once 'config.php';


// connect to database
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($mysqli->connect_error)
{
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
if (!$mysqli->set_charset("utf8mb4")) {
    printf("Error loading character set utf8mb4: %s\n", $mysqli->error);
    exit();
}

$targetFacilityUUID = $_POST["targetFacilityUUID"];

$stmt = $mysqli->prepare("SELECT title, info, uuid FROM group_list WHERE facility_uuid = ? ORDER BY title ASC");
$stmt->bind_param("s", $targetFacilityUUID); // "s" steht für string

$stmt->execute();
$result = $stmt->get_result(); // Ergebnis als mysqli_result Objekt erhalten


while ($row = $result->fetch_assoc()) {

    echo $row['title']."<¦>";
    echo $row['info']."<¦>";
    echo $row['uuid']."<|>";

}    

$stmt->close();


?>