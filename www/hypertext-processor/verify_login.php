<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

function verify_login($username, $password, $group_uuid, $mysqli)
{
    $safe_group_uuid = $mysqli->real_escape_string($group_uuid);
    $tableName = "`{$safe_group_uuid}______group_users`";


    // Die Funktion prepare muss auf einem gültigen mysqli-Objekt aufgerufen werden
    $stmt = $mysqli->prepare("SELECT password_hash, role, first_name, last_name FROM $tableName WHERE username = ?");
    
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

            return [
                'authsuccess' => true,
                'role' => $user['role'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'username' => $username,
            ];
        }
    }

    // Schließen des Statements
    $stmt->close();
    return [
        'authsuccess' => false,
        'role' => "",
        'first_name' => "",
        'last_name' => "",
        'username' => ""
    ];
}

?>