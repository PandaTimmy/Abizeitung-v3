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

    echo '
    <h3 class="no-margin" style="margin-bottom: 20px">Einrichtungen Verwalten</h3>
        <div class="button-icon-container condenced">
    ';

    $query = "SELECT name, address, uuid FROM facilities ORDER BY name ASC";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            echo '
            <div class="button-icon" onmouseup="setCookie(\'facilityTarget\',\''.$row['uuid'].'\',\'0.0001\'); navigate(\'-admin-facilities-edit\', \'crossfade\', false)">
                <img class="button-image" src="images/icons/rankings_selected.svg" alt="">
                <div class="button-textcontent">
                    <div class="button-title">'.$row['name'].'</div>
                    <div class="button-subtitle">'.$row['address'].'</div>
                </div>
            </div>
            ';
            //echo $row['uuid']."<|>";

        }
    }
            
    echo '
    </div><div class="space74"></div>
    ';

    echo '<div class="default-button" onclick="navigate(\'-admin-facilities-add\', \'crossfade\', false)">Einrichtung hinzufügen</div>';

}

?>