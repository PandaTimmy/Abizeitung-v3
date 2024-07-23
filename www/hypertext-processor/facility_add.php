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

// import verify admin token
include('token_verify_admin.php');

$accessToken = $_COOKIE["accessToken"] ?? "";
$refreshToken = $_COOKIE["refreshToken"] ?? "";

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($mysqli->connect_error)
{
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
if (!$mysqli->set_charset("utf8mb4")) {
    printf("Error loading character set utf8mb4: %s\n", $mysqli->error);
    exit();
}

$verify_admin = token_verify_admin($accessToken, $refreshToken);

if (!$verify_admin["authsuccess"]) {

    // incorrect password
    echo "-1";

} else {

    $facilityName = $_POST["facilityName"] ?? '';
    $facilityAddress = $_POST["facilityAddress"] ?? '';
    $facilityUUID = Uuid::uuid4()->toString();

    $query = "INSERT INTO facilities (name , address ,uuid) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sss", $facilityName, $facilityAddress, $facilityUUID);
    $success = $stmt->execute();

    if ($success) {
        echo "1";
    } else {
        echo "0";
    }
    
    $stmt->close();
    $mysqli->close();
}

?>