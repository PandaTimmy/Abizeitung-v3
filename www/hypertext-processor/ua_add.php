<?php

header('Content-Type: text/html; charset=utf-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// import uuid v4 - use "Uuid::uuid4()->toString();" to generate
require 'vendor/autoload.php';
use Ramsey\Uuid\Uuid;

// import databaseconfiguration
require_once 'config.php';

// import verify admin
include('token_verify_login.php');

include('generate_password.php');


$accessToken = $_COOKIE["accessToken"] ?? "";
$refreshToken = $_COOKIE["refreshToken"] ?? "";


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

$verify_login = token_verify_login($accessToken, $refreshToken);

if (!$verify_login["authsuccess"] || $verify_login["authsuccess"] != "oa") {

    // incorrect password
    die('-1<|>Sitzung abgelaufen');

} else {

    // correct admin login

    $uaAddFirstName = $_POST["uaAddFirstName"];
    $uaAddLastName = $_POST["uaAddLastName"];

    if (strlen($uaAddFirstName) < 2 || strlen($uaAddFirstName) > 20) {
        die('0<|>Ungültiger Vorname');
    }
    if (strlen($uaAddLastName) < 2 || strlen($uaAddLastName) > 20) {
        die('0<|>Ungültiger Nachname');
    }

    $safe_group_uuid = $mysqli->real_escape_string($verify_login["guuid"]);
    $tableName = "`{$safe_group_uuid}______group_users`";

    $uaUsername = $uaAddFirstName . substr($uaAddLastName, 0, 3);

    $incrementCounter = "";
    $foundAvailibleUsername = false;

    $ua_password = generatePassword(6);
    $ua_hashed_password = password_hash($ua_password, PASSWORD_BCRYPT);


    // increment username by 1 until an availible username is found
    while (!$foundAvailibleUsername) {

        // check username availability
        $query = "SELECT COUNT(*) AS count FROM $tableName WHERE username = ?";
        $stmt = $mysqli->prepare($query);
        $search_for_username = $uaUsername.$incrementCounter;
        $stmt->bind_param("s", $search_for_username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
        
            // username taken

            if ($incrementCounter == "") {
                $incrementCounter = 2;
            } else {
                $incrementCounter++;
            }
        } else {

            // username availible

            $foundAvailibleUsername = true;
            $uaUsername = $uaUsername.$incrementCounter;
        }
    }
    $stmt->close();



    $uuid = Uuid::uuid4()->toString();

    $role = "ua";

    //prepared statement
    $stmt = $mysqli->prepare("INSERT INTO $tableName (
        `username`,
        `uuid`,
        `first_name`,
        `last_name`,
        `password_hash`,
        `role`,
        `default_pass`
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?
    );");

    $stmt->bind_param("sssssss",
        $uaUsername,
        $uuid,
        $uaAddFirstName,
        $uaAddLastName,
        $ua_hashed_password,
        $role,
        $ua_password
    );

    if ($stmt->execute()) {
        echo "1<|>Erfolgreich Einrichtung hinzugefügt.<hr>";


    } else {
        // error handling
        $error = $stmt->error;
        echo "0<|>Fehler beim hinzufügen " . $error;
    }

    $stmt->close();

}

$mysqli->close();

