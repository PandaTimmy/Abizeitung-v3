<?php
// import databaseconfiguration
require_once 'config.php';

if (DISPLAY_ERRORS_BOOL) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;



function token_verify_admin($accessToken, $refreshToken) {

    $secretKey = SECRET_KEY;
    $refreshSecretKey = REFRESH_SECRET_KEY;

    try {
        $decoded = JWT::decode($accessToken, new Key($secretKey, 'HS256'));

        // Admin Token ist noch gültig

        $username = $decoded->sub;
        $role = $decoded->role;

        if ($role == "aa") {

            return array(
                'authsuccess' => true,
                'username' => $username
            );

        } else {

            return array(
                'authsuccess' => false,
                'username' => $username
            );
        }

        

    } catch (\Exception $e) {

        // Prüfen, ob Admin Token erneuert werden kann

        try {
            $decodedRefresh = JWT::decode($refreshToken, new Key($refreshSecretKey, 'HS256'));
            $newAccessToken = renew_access_token($decodedRefresh->sub, $decodedRefresh->role, $secretKey);

            $issuedAt = time();
            $refreshExpirationTime = $issuedAt + 3600;  // Neuer Acces Token läuft in 1 Stunde ab

            setcookie("accessToken", $newAccessToken, $refreshExpirationTime, "/", "", SECURE_COOKIE_BOOL, false);

            // Es konnte erneuert werden

            $username = $decodedRefresh->sub;
            $role = $decodedRefresh->role;

            if ($role == "aa") {

                return array(
                    'authsuccess' => true,
                    'username' => $username
                );

            } else {
    
                return array(
                    'authsuccess' => false,
                    'username' => $username
                );
            }

        } catch (\Exception $e) {

            // Ungültig

            return array(
                'authsuccess' => false,
                'username' => ""
            );
        }
    }

}

// Funktion zur Erneuerung des Access Tokens
function renew_access_token($username, $role, $key) {
    $issuedAt = time();
    $expirationTime = $issuedAt + 3600;  // Access Token läuft in 1 Stunde ab

    $payload = [
        "iss" => TOKEN_ISS,
        "aud" => TOKEN_AUD,
        "iat" => $issuedAt,
        "exp" => $expirationTime,
        "sub" => $username,
        "role" => $role
    ];

    return JWT::encode($payload, $key, 'HS256');
}


?>
