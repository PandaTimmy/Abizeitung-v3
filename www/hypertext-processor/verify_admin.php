<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

function verify_admin($username, $password, $mysqli)
{

    $stmt = $mysqli->prepare("SELECT password_hash FROM admin_users WHERE username = ?");

    // Binden der Variablen an die Parameter des Prepared Statements
    $stmt->bind_param("s", $username);
    
    // Ausführen des Prepared Statements
    $stmt->execute();
    
    // Ergebnisse abrufen
    $result = $stmt->get_result();
    
    // Überprüfung, ob Benutzer gefunden wurde
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Vergleich des bereitgestellten Passworts mit dem gespeicherten Passwort-Hash
        if (password_verify($password, $user['password_hash'])) {
            $stmt->close();
            return true;
        }
    }

    // Schließen des Statements
    $stmt->close();
    return false;
}

// // Verwendung der Funktion mit mysqli-Objekt
// $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// if ($mysqli->connect_error) {
//     die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
// }

// // Aufruf der Funktion, Beispiel
// $login_successful = verify_admin("f5caf163-bfbc-48c6-8a3d-d51b0c5a42d7", "woxAo2-tysnik-xEprZq-tfs§ik-xGpyXq", $mysqli);
// $mysqli->close();

// // Behandlung des Login-Status
// if ($login_successful) {
//     echo "Login erfolgreich!";
// } else {
//     echo "Login fehlgeschlagen!";
// }

?>