<?php

header('Content-Type: text/html; charset=utf-8');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// import uuid v4 - use "Uuid::uuid4()->toString();" to generate
require 'vendor/autoload.php';
use Ramsey\Uuid\Uuid;

// import databaseconfiguration
require_once 'config.php';

// import random password generater
include('generate_password.php');

// import verify admin
include('verify_admin.php');

$group_title = $_POST["groupTitle"];
$group_info = $_POST["groupInfo"];
$group_facility_uuid = $_POST["groupFacilityUUID"];
$oa_first_name = $_POST["oaFirstName"];
$oa_last_name = $_POST["oaLastName"];
$oa_contact_email = $_POST["oaContactEmail"];


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

if (strlen($group_title) < 4) {
    die('0<|>Ungültiger Titel');
}

if (strlen($group_title) > 64) {
    die('0<|>Titel zu lang');
}

if (strlen($group_info) < 4) {
    die('0<|>Ungültige Beschreibung');
}

if (strlen($group_info) > 1000) {
    die('0<|>Beschreibung zu lang');
}

if (strlen($oa_first_name) < 3 || strlen($oa_first_name) > 20) {
    die('0<|>Ungültiger Vorname');
}

if (strlen($oa_last_name) < 3 || strlen($oa_last_name) > 20) {
    die('0<|>Ungültiger Nachname');
}

if (!filter_var($oa_contact_email, FILTER_VALIDATE_EMAIL)) {
    die('0<|>Ungültige E-Mail-Adresse');
}

$stmt = $mysqli->prepare("SELECT COUNT(*) FROM facilities WHERE uuid = ?");
$stmt->bind_param("s", $group_facility_uuid); // "s" steht für string

// Statement ausführen
$stmt->execute();

// Ergebnis holen
$stmt->bind_result($count);
$stmt->fetch();

if ($count == 0) {
    die('0<|>Interner Fehler');
}

$stmt->close();

$group_uuid = Uuid::uuid4()->toString();
$group_creation_date = date("Y-m-d H:i:s");
$group_organisation_account_uuid = Uuid::uuid4()->toString();
$group_organisation_account_password = generatePassword();
$group_organisation_account_hashed_password = password_hash($group_organisation_account_password, PASSWORD_BCRYPT);
$group_organisation_account_permissions = "oa";
$group_organisation_account_username = $oa_first_name . substr($oa_last_name, 0, 3);

$mysqli->begin_transaction();

try {

    // GRUPPE IN GRUPPENLISTE HINZU

    $stmt = $mysqli->prepare("INSERT INTO `group_list` (
        `uuid`,
        `title`,
        `info`,
        `creation_date`,
        `organisation_account_uuid`,
        `facility_uuid`,
        `contact_email`
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?
    );");

    $stmt->bind_param("sssssss",
        $group_uuid,
        $group_title,
        $group_info,
        $group_creation_date,
        $group_organisation_account_uuid,
        $group_facility_uuid,
        $oa_contact_email
    );

    $stmt->execute();
    $stmt->close();

    // GRUPPEN KONTO LISTE HINZU

    $group_users_tablename = $group_uuid . "______" . "group_users";

    $command = "CREATE TABLE `" . $group_users_tablename . "` (
        username VARCHAR(23), 
        uuid CHAR(36) PRIMARY KEY, 
        first_name VARCHAR(20), 
        last_name VARCHAR(20), 
        password_hash CHAR(128), 
        role VARCHAR(20),
        default_pass VARCHAR(64)
    );";

    $mysqli->query($command);

    // OA ZU GRUPPEN KONTO LISTE HINZU

    $stmt = $mysqli->prepare("INSERT INTO `" . $group_users_tablename . "` (
        `username`, 
        `uuid`,
        `first_name`,
        `last_name`,
        `password_hash`,
        `role`,
        `default_pass`
    ) VALUES (?, ?, ?, ?, ?, ?, ?);");

    $defaultPass = "";

    $stmt->bind_param("sssssss",
        $group_organisation_account_username,
        $group_organisation_account_uuid,
        $oa_first_name,
        $oa_last_name,
        $group_organisation_account_hashed_password,
        $group_organisation_account_permissions,
        $defaultPass
    );

    $stmt->execute();
    $stmt->close();

    // BEICHTEN LISTE ERSTELLEN

    $table_name_beichten =           $group_uuid . "______" . "beichten";
    $table_name_storys =             $group_uuid . "______" . "storys";
    $table_name_zitate =             $group_uuid . "______" . "zitate";
    $table_name_group_settings =     $group_uuid . "______" . "group_settings";
    $table_name_group_log =          $group_uuid . "______" . "group_log";
    $table_name_umfragen_list =      $group_uuid . "______" . "surveys_list";
    $table_name_rankings_list =      $group_uuid . "______" . "rankings_list";
    $table_name_abstimmungen_list =  $group_uuid . "______" . "votes_list";

    $command = "CREATE TABLE `".$table_name_beichten."` (
        beichte VARCHAR(5000), 
        datum DATETIME, 
        status VARCHAR(64), 
        uuid CHAR(36), 
        autor VARCHAR(128)
    );";

    $mysqli->query($command);

    // STORY LISTE ERSTELLEN

    $command = "CREATE TABLE `".$table_name_storys."` (
        story VARCHAR(5000), 
        datum DATETIME, 
        status VARCHAR(64), 
        uuid CHAR(36), 
        titel VARCHAR(128)
    );";

    $mysqli->query($command);

    // ZITATE LISTE ERSTELLEN

    $command = "CREATE TABLE `".$table_name_zitate."` (
        zitat VARCHAR(5000), 
        datum DATETIME, 
        status VARCHAR(64), 
        uuid CHAR(36) 
    );";

    $mysqli->query($command);

    // GRUPPEN EINSTELLUNGEN LISTE ERSTELLEN

    $command = "CREATE TABLE `".$table_name_group_settings."` (
        einstellung VARCHAR(100), 
        status VARCHAR(100)
    );";

    $mysqli->query($command);

    // GRUPPEN LOG LISTE ERSTELLEN

    $command = "CREATE TABLE `".$table_name_group_log."` (
        log VARCHAR(1000),
        datum DATETIME
    );";

    $mysqli->query($command);
                
    // GRUPPEN UMFRAGE LISTE ERSTELLEN

    $command = "CREATE TABLE `".$table_name_umfragen_list."` (
        titel VARCHAR(128), 
        beschreibung VARCHAR(1000), 
        status VARCHAR(64),
        datum DATETIME, 
        antwortenListeUUID CHAR(36)
    );";

    $mysqli->query($command);

    // GRUPPEN RANKINGS LISTE ERSTELLEN

    $command = "CREATE TABLE `".$table_name_rankings_list."` (
        titel VARCHAR(128), 
        beschreibung VARCHAR(1000), 
        auswahlListeUUID CHAR(36), 
        antwortenListeUUID CHAR(36),
        status VARCHAR(64),
        datum DATETIME
    );";

    $mysqli->query($command);

    // GRUPPEN ABSTIMMUNGEN LISTE ERSTELLEN

    $command = "CREATE TABLE `".$table_name_abstimmungen_list."` (
        titel VARCHAR(128), 
        beschreibung VARCHAR(1000), 
        auswahlListeUUID CHAR(36), 
        antwortenListeUUID CHAR(36),
        status VARCHAR(64),
        datum DATETIME
    );";

    $mysqli->query($command);

    $mysqli->commit();

    echo "1<|>".$group_organisation_account_password."<|>".$group_organisation_account_username;

} catch (Exception $e) {
    // Bei einem Fehler die Transaktion zurückrollen
    $mysqli->rollback();
    echo "-1<|>Erstellen fehlgeschlagen: " . $e->getMessage();
}

$mysqli->close();


