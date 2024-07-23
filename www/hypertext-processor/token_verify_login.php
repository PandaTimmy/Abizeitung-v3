<?php
// import databaseconfiguration
require_once 'config.php';

if (true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;



function token_verify_login($accessToken, $refreshToken) {

    $secretKey = SECRET_KEY;
    $refreshSecretKey = REFRESH_SECRET_KEY;


    try {
        $decoded = JWT::decode($accessToken, new Key($secretKey, 'HS256'));

        // Admin Token ist noch gültig

        $username = $decoded->sub;
        $role = $decoded->role;
        $guuid = $decoded->guuid;

        if ($role == "oa" || $role == "ua") {

            return array(
                'authsuccess' => true,
                'username' => $username,
                'role' => $role,
                'guuid' => $guuid
            );

        } else {

            return array(
                'authsuccess' => false,
                'username' => "",
                'role' => "",
                'guuid' => ""
            );
        }

        

    } catch (\Exception $e) {

        // Prüfen, ob Admin Token erneuert werden kann

        try {

            $decodedRefresh = JWT::decode($refreshToken, new Key($refreshSecretKey, 'HS256'));
            $username = $decodedRefresh->sub;
            $guuid = $decodedRefresh->guuid;

            if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[4][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $guuid)) { // Ungültiges GUUID Format
                return array(
                    'authsuccess' => false,
                    'username' => "",
                    'role' => "",
                    'guuid' => ""
                );
            }

            // connect to database
            $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
            if ($mysqli->connect_error)
            {
                return array(
                    'authsuccess' => false,
                    'username' => "",
                    'role' => "",
                    'guuid' => ""
                );
            }
            if (!$mysqli->set_charset("utf8mb4")) {
                return array(
                    'authsuccess' => false,
                    'username' => "",
                    'role' => "",
                    'guuid' => ""
                );
            }

            $tableName = $mysqli->real_escape_string($guuid . "______group_users");

            $stmt = $mysqli->prepare("SELECT role FROM `$tableName` WHERE username = ?");

            // Binden der Variablen an die Parameter des Prepared Statements
            $stmt->bind_param("s", $username);

            // Ausführen des Prepared Statements
            $stmt->execute();

            // Ergebnisse abrufen
            $result = $stmt->get_result();
            
            // Überprüfung, ob Benutzer gefunden wurde
            if ($result->num_rows > 0) {

                $user = $result->fetch_assoc();
                $role = $user['role'];

            } else {

                $stmt->close();
                $mysqli->close();

                return array(
                    'authsuccess' => false,
                    'username' => "",
                    'role' => "",
                    'guuid' => ""
                );
            }

            $stmt->close();
            $mysqli->close();

            if ($role != "oa" && $role != "ua") {
                return array(
                    'authsuccess' => false,
                    'username' => "",
                    'role' => "",
                    'guuid' => ""
                );
            }

            $newAccessToken = renew_access_token_login($username, $role, $guuid, $secretKey);

            $issuedAt = time();

            if ($role == "oa") {
                $refreshExpirationTime = $issuedAt + 3600;  // Neuer Acces Token für OA läuft in 60 Sekunden ab
            } else {
                $refreshExpirationTime = $issuedAt + 3600;  // Neuer Acces Token für UA läuft in 1 Stunde ab
            }


            setcookie("accessToken", $newAccessToken, $refreshExpirationTime, "/", "", SECURE_COOKIE_BOOL, HTTP_ONLY_BOOL);

            // Es konnte erneuert werden


            if ($role == "oa" || $role == "ua") {

                return array(
                    'authsuccess' => true,
                    'username' => $username,
                    'role' => $role,
                    'guuid' => $guuid
                );

            } else {
    
                return array(
                    'authsuccess' => false,
                    'username' => "",
                    'role' => "",
                    'guuid' => ""
                );
            }

        } catch (\Exception $e) {

            // Ungültig

            return array(
                'authsuccess' => false,
                'username' => "",
                'role' => "",
                'guuid' => ""
            );
        }
    }

}

// Funktion zur Erneuerung des Access Tokens
function renew_access_token_login($username, $role, $guuid, $key) {
    $issuedAt = time();
    $expirationTime = $issuedAt + 3600;  // Access Token läuft in 1 Stunde ab

    $payload = [
        "iss" => TOKEN_ISS,
        "aud" => TOKEN_AUD,
        "iat" => $issuedAt,
        "exp" => $expirationTime,
        "sub" => $username,
        "role" => $role,
        "guuid" => $guuid
    ];

    return JWT::encode($payload, $key, 'HS256');
}


?>
