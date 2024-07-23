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
    $uauuid = $_POST["uauuid"] ?? "";

    $stmt = $mysqli->prepare("SELECT first_name, last_name, uuid, username, role, default_pass FROM $tableName WHERE uuid = ?");

    // Binden der Variablen an die Parameter des Prepared Statements
    $stmt->bind_param("s", $uauuid);

    // Ausführen des Prepared Statements
    $stmt->execute();

    // Ergebnisse abrufen
    $result = $stmt->get_result();
    
    // Überprüfung, ob Benutzer gefunden wurde
    if ($result->num_rows > 0) {

        echo "1<|>";

        $result = $result->fetch_assoc();

        $stmt->close();


        $role = $result['role'];

        if ($result['role'] == "oa") {
            $berechtigungenText = "Admin";
            $berechtigungenÄndernText = "Adminstatus entfernen";
        } else {
            $berechtigungenText = "Kein Admin";
            $berechtigungenÄndernText = "Zum Admin machen";
        }

        echo "
        <h2 class='no-margin'>".$result['first_name']." ".$result['last_name']."</h2>
        <div class='space74'></div>
        <h3 class='notop'>Berechtigungen</h3>
        <h3 class='no-margin light'>$berechtigungenText</h3>
        <div class='default-button' style='margin-top: 20px;' onclick='internAlert(\"Lädt...\")'>$berechtigungenÄndernText</div>
        <div class='default-button' onclick='internAlert(\"Lädt...\")'>Loginlink Kopieren</div>
        <h3 class='light'>Konto Bearbeiten</h3>
        <div class='input-grid'>
        ";

        echo "
        <div>
            <h3 class='condenced'>Vorname</h3>
            <textarea id='uaEditFirstName' autocomplete='0ff' autocorrect='off' spellcheck='off' autocapitalize='off' class='auto-resize' name='' style='pointer-events: all;' placeholder='Vorname eingeben...'>".$result['first_name']."</textarea>
        </div>
        ";

        echo "
        <div>
            <h3 class='condenced' class='condenced'>Nachname</h3>
            <textarea id='uaEditLastName' autocomplete='0ff' autocorrect='off' spellcheck='off' autocapitalize='off' class='auto-resize' name='' style='pointer-events: all;' placeholder='Nachname eingeben...'>".$result['last_name']."</textarea>
        </div>
        ";

        echo "
        <div>
            <h3 class='condenced'>Benutzername</h3>
            <textarea style='pointer-events: none;' id='uaEditUsername' disabled autocomplete='0ff' autocorrect='off' spellcheck='off' autocapitalize='off' class='auto-resize' name='' style='pointer-events: all;' placeholder='Benutzername eingeben...'>".$result['username']."</textarea>
        </div>
        ";

        if ($result['default_pass'] != "") {
            echo "
            <div>
                <h3 class='condenced'>Voreingestelltes Passwort</h3>
                <textarea style='pointer-events: none;' id='uaEditUsername' disabled autocomplete='0ff' autocorrect='off' spellcheck='off' autocapitalize='off' class='auto-resize' name='' style='pointer-events: all;' placeholder='Passwort eingeben...'>".$result['default_pass']."</textarea>
            </div>
            ";
        } else {
            echo "
            <div>
                <h3 class='condenced'>Voreingestelltes Passwort</h3>
                <textarea style='pointer-events: none;' id='uaEditUsername' disabled autocomplete='0ff' autocorrect='off' spellcheck='off' autocapitalize='off' class='auto-resize' name='' style='pointer-events: all;' placeholder='Passwort eingeben...'>Mittlerweile geändert</textarea>
            </div>
            ";
        }

        echo "
        </div>
        <h3>Logindaten</h3>

        <div class='input-grid'>";

        if ($result['default_pass'] == "") {

            // Loginlink nicht gültig

            echo "
            <div class='default-button' onclick='internAlert(\"Loginlink nicht verfügbar\")' style='color: rgba(255,255,255,0.33)'>Loginlink Kopieren</div>
            
            <div class='default-button' onclick='internAlert(\"Logindaten nicht verfügbar\")' style='color: rgba(255,255,255,0.33) onclick='internAlert()'>Logindaten Kopieren</div>";
        }
        else {
            echo "
            <div class='default-button' onclick='internAlert(\"Loginlink kopiert\")'>Loginlink Kopieren</div>
    
            <div class='default-button' onclick='internAlert(\"Logindaten kopiert\")'>Logindaten Kopieren</div>
            ";
        }

        echo "
        <div class='default-button red' onclick='internAlert()'>Passwort Zurücksetzen</div>
        <div class='default-button red' onclick='internAlert()'>Konto Löschen</div>
        </div>
        ";

 

    } else {

        $stmt->close();

        die('0<|>Benutzer nicht gefunden');
    }


}

$mysqli->close();

