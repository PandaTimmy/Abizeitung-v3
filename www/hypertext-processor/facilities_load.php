<?php

header('Content-Type: text/html; charset=utf-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// import databaseconfiguration
require_once 'config.php';

function load_facilities() {

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

    $query = "SELECT name, address, uuid FROM facilities ORDER BY name ASC";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            echo $row['name']."<¦>";
            echo $row['address']."<¦>";
            echo $row['uuid']."<|>";

        }
    }
}

load_facilities();

?>