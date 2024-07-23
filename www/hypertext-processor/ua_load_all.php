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

    $safe_group_uuid = $mysqli->real_escape_string($verify_login["guuid"]);
    $tableName = "`{$safe_group_uuid}______group_users`";

    $query = "SELECT first_name, last_name, uuid, username, role FROM $tableName ORDER BY role ASC, first_name ASC";
    $result = $mysqli->query($query);

    echo "1<|>";

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {


            if ($row['username'] == $verify_login["username"]) {
                $text = "DU";
            } else if ($row['role'] == "oa") {
                $text = "ADMIN";
            } else {
                $text = "";
            }

            echo "
            <div class='button-icon' onmouseup='uauuidToLoad = \"".$row["uuid"]."\"; navigate(\"ua-edit\")'>
                <img class='button-image' src='images/icons/profile_selected.svg' alt=''>
                <div class='button-textcontent'>
                    <div class='button-title'>".$row['first_name']."</div>
                    <div class='button-subtitle'>".$row['last_name']."</div>
                </div>
                <div class='button-sidenote'>
                    <div class='button-sidenote-textcontent'>$text</div>
                </div>
            </div>
            ";

        }
    }

}

$mysqli->close();

