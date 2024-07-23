<?php

header('Content-Type: text/html; charset=utf-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// import databaseconfiguration
require_once 'config.php';

// import verify admin
include('verify_login.php');

// import verify admin token
include('token_verify_login.php');


require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function login($username, $password, $groupUUID) {

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

    $safe_group_uuid = $mysqli->real_escape_string($groupUUID);

    $verify_login = verify_login($username, $password, $groupUUID, $mysqli);

    if (!$verify_login["authsuccess"]) {

        // incorrect password

        echo "0";

    } else {

        $issuedAt = time();

        if($verify_login["role"] == "oa") {
            $expirationTime = $issuedAt + 60;  // Access Token für OAs läuft in 1 Minute ab
            $role = "oa";

        } else {
            $expirationTime = $issuedAt + 3600;  // Access Token für UAs läuft in 1 Stunde ab
            $role = "ua";
        }

        $refreshExpirationTime = $issuedAt + 2628288;  // Refresh Token läuft in 1 Monat ab


        $payload = [
            "iss" => TOKEN_ISS,
            "aud" => TOKEN_AUD,
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "sub" => $username,
            "role" => $role,
            "guuid" => $groupUUID
        ];

        $refreshPayload = [
            "iss" => TOKEN_ISS,
            "aud" => TOKEN_AUD,
            "iat" => $issuedAt,
            "exp" => $refreshExpirationTime,
            "sub" => $username,
            "role" => $role,
            "guuid" => $groupUUID
        ];

        // Access Token erstellen
        $secretKey = SECRET_KEY;
        $jwt = JWT::encode($payload, $secretKey, 'HS256');

        // Refresh Token erstellen
        $refreshSecretKey = REFRESH_SECRET_KEY;
        $refreshJwt = JWT::encode($refreshPayload, $refreshSecretKey, 'HS256');

        // Tokens an den Client senden
        setcookie("refreshToken", $refreshJwt, $refreshExpirationTime, "/", "", SECURE_COOKIE_BOOL, HTTP_ONLY_BOOL);
        setcookie("accessToken", $jwt, $expirationTime, "/", "", SECURE_COOKIE_BOOL, HTTP_ONLY_BOOL);
        setcookie("first_name", $verify_login["first_name"], $refreshExpirationTime, "/", "", SECURE_COOKIE_BOOL, false);
        setcookie("last_name", $verify_login["last_name"], $refreshExpirationTime, "/", "", SECURE_COOKIE_BOOL, false);
        setcookie("role", $verify_login["role"], $refreshExpirationTime, "/", "", SECURE_COOKIE_BOOL, false);
        setcookie("username", $verify_login["username"], $refreshExpirationTime, "/", "", SECURE_COOKIE_BOOL, false);

        echo "1";

    }
}

$username = $_POST["username"] ?? '';
$password = $_POST["password"] ?? '';
$groupUUID = $_POST["groupUUID"] ?? '';

login($username, $password, $groupUUID);

?>