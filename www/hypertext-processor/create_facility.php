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
include('verify_admin.php');

function create_facility($username, $password, $name, $adress)
{
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

    if (!verify_admin($username, $password, $mysqli)) {

        // incorrect password
        echo "Falsche Admin zugangsdaten";

    } else {

        // correct admin login

        $uuid = Uuid::uuid4()->toString();

        // prepared statement
        $stmt = $mysqli->prepare("INSERT INTO `facilities` (
            `name`,
            `address`,
            `uuid`
        ) VALUES (
            ?, ?, ?
        );");

        $stmt->bind_param("sss",
            $name,
            $adress,
            $uuid
        );

        if ($stmt->execute()) {
            echo "Erfolgreich Einrichtung hinzugefügt.<hr>";


        } else {
            // error handling
            $error = $stmt->error;
            echo "Fehler beim hinzufügen " . $error;
        }

        $stmt->close();

    }

    $mysqli->close();
}

//create_group('TimothyKlimke', 'woxAo2-tysnik-xEprZq-tfs§ik-xGpyXq', 'Beispielgruppe', 'Dies ist eine Beispielgruppe', 'Timothy', 'Klimke');

$aa_name = $_POST["aa-name"];
$aa_password = $_POST["aa-password"];
$facilty_name = $_POST["facilty-name"];
$facilty_address = $_POST["facilty-address"];

create_facility($aa_name, $aa_password, $facilty_name, $facilty_address);
