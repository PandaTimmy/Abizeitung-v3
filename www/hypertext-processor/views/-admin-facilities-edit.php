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

    $facilityUUID = $_COOKIE["facilityTarget"] ?? ':(';


    echo '<h3 class="no-margin" style="margin-bottom: 20px">Einrichtung Verwalten</h3>';

    $query = "SELECT name, address FROM facilities WHERE uuid = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $facilityUUID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            echo '<h3>Name | Bearbeiten</h3>';
            echo '
            <textarea id="-admin-manage-facility-name" autocomplete="0ff" autocorrect="off" spellcheck="off" autocapitalize="off" class="auto-resize" name="" style="pointer-events: all;" placeholder="Neuen Namen eingeben...">'.$row["name"].'</textarea>
            ';

            echo '<h3>Adresse | Bearbeiten</h3>';
            echo '
            <textarea id="-admin-manage-facility-address" autocomplete="0ff" autocorrect="off" spellcheck="off" autocapitalize="off" class="auto-resize" name="" style="pointer-events: all;" placeholder="Neue Adresse eingeben...">'.$row["address"].'</textarea>
            ';
            
            //echo '<h3>UUID</h3>';
            //echo '<h3 id="-admin-manage-facility-uuid" class="no-margin" style="word-break: break-all;">'.$facilityUUID.'</h3>';

            echo '<div class="space74"></div>';
            echo '<div onclick="
            
            customConfirm(\'Möchtest Du die Änderungen wirklich speichern?\', \'Speichern\', \'Abbrechen\', function(confirmed) {
            if (confirmed) {

                saveFacilityEdits(\''.$facilityUUID.'\');

            } else {
            }
        });
            
            " class="default-button">Änderungen speichern</div>';


            echo '<div onclick="
            
            customConfirm(\'Möchtest Du wirklich die Einrichtung \”'.$row["name"].'\” löschen?\', \'Löschen\', \'Abbrechen\', function(confirmed) {
                if (confirmed) {

                    deleteFacility(\''.$facilityUUID.'\')

                } else {
                }
            });
            
            " class="default-button red">Einrichtung löschen</div>';

        }
    }
            
    echo '
    ';

}

?>