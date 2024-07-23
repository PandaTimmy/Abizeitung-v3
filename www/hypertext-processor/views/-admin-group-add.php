<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// import uuid v4 - use "Uuid::uuid4()->toString();" to generate
require '../vendor/autoload.php';
use Ramsey\Uuid\Uuid;

// import databaseconfiguration
require_once '../config.php';

// import verify admin token
include('../token_verify_admin.php');

$accessToken = $_COOKIE["accessToken"] ?? "";
$refreshToken = $_COOKIE["refreshToken"] ?? "";

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($mysqli->connect_error)
{
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$verify_admin = token_verify_admin($accessToken, $refreshToken);

if (!$verify_admin["authsuccess"]) {

    // incorrect password
    echo "404";

} else {

    echo '<h3 class="no-margin light" style="margin-bottom: 20px">Gruppe Erstellen</h3>';


    echo '<h3>Gruppentitel</h3>';
    echo '
    <textarea id="-admin-add-facility-name" autocomplete="0ff" autocorrect="off" spellcheck="off" autocapitalize="off" class="auto-resize" name="" style="pointer-events: all;" placeholder="Gruppentitel eingeben..."></textarea>
    ';

    echo '<h3>Beschreibung</h3>';
    echo '
    <textarea id="-admin-add-facility-address" autocomplete="0ff" autocorrect="off" spellcheck="off" autocapitalize="off" class="auto-resize" name="" style="pointer-events: all;" placeholder="Beschreibung eingeben..."></textarea>
    ';

    echo '<div class="space74"></div>';

    echo '<h3 class="no-margin light" style="margin-bottom: 20px">Organisator Festlegen</h3>';

    echo '<h3>Vorname</h3>';
    echo '
    <textarea id="-admin-add-facility-name" autocomplete="0ff" autocorrect="off" spellcheck="off" autocapitalize="off" class="auto-resize" name="" style="pointer-events: all;" placeholder="Vorname eingeben..."></textarea>
    ';

    echo '<h3>Nachname</h3>';
    echo '
    <textarea id="-admin-add-facility-address" autocomplete="0ff" autocorrect="off" spellcheck="off" autocapitalize="off" class="auto-resize" name="" style="pointer-events: all;" placeholder="Nachname eingeben..."></textarea>
    ';



    echo '<div class="space74"></div>';
    echo '<div onclick="
    
    customConfirm(\'Möchtest du diese Einrichtung wirklich erstellen?\', \'Erstellen\', \'Abbrechen\', function(confirmed) {
    if (confirmed) {

        addFacility();

    } else {
    }
});
    
    " class="default-button">Einrichtung erstellen</div>';


}

?>