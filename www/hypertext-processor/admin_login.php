<?php

header('Content-Type: text/html; charset=utf-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// import databaseconfiguration
require_once 'config.php';

// import verify admin
include('verify_admin.php');

// import verify admin token
include('token_verify_admin.php');


require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function admin_login($username, $password) {

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

        echo "0";

    } else {

        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // Access Token läuft in 1 Stunde ab
        $refreshExpirationTime = $issuedAt + 2419200;  // Refresh Token läuft in 4 Wochen ab

        $role = "aa";

        $payload = [
            "iss" => TOKEN_ISS,
            "aud" => TOKEN_AUD,
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "sub" => $username,
            "role" => $role
        ];

        $refreshPayload = [
            "iss" => TOKEN_ISS,
            "aud" => TOKEN_AUD,
            "iat" => $issuedAt,
            "exp" => $refreshExpirationTime,
            "sub" => $username,
            "role" => $role
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
        
        echo "1";

    }
}

$aa_username = $_POST["aaUsername"] ?? '';
$aa_password = $_POST["aaPassword"] ?? '';

admin_login($aa_username, $aa_password);

?>