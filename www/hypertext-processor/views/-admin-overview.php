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
    
        <h2 class="no-margin">'.$verify_admin["username"].'</h2>
        <h3 class="no-margin">Admin Seite</h3>

        <br><br>

        <div class="button-icon-container">

            <div class="button-icon" onmouseup="navigate(\'-admin-facilities-overview\', \'crossfade\', false)">
                <img class="button-image" src="images/icons/rankings_selected.svg" alt="">
                <div class="button-textcontent">
                    <div class="button-title">Einrichtungen</div>
                </div>
            </div>

            <div class="button-icon" onmouseup="navigate(\'quotes\', \'crossfade\', false)">
                <img class="button-image" src="images/icons/group_selected.svg" alt="">
                <div class="button-textcontent">
                    <div class="button-title">Gruppen</div>
                </div>
            </div>

        </div>
    ';

}

?>