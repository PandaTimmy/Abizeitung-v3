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


$user_uuid = $_POST["logincode"]; // Der Wert, nach dem gesucht werden soll

// Abrufen der UUIDs aus der group_list Tabelle
$query = 'SELECT uuid FROM group_list';
$result = $mysqli->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $group_uuid = $row['uuid'];
        $table_name = $group_uuid . '______group_users';
        $sql_query = "SELECT * FROM `$table_name` WHERE uuid = ?";


        if ($stmt = $mysqli->prepare($sql_query)) {
            $stmt->bind_param('s', $user_uuid);
            $stmt->execute();
            $result_inner = $stmt->get_result();

            // Ausgabe der gefundenen Zeilen
            while ($row_inner = $result_inner->fetch_assoc()) {
                $GUUID        = substr($table_name, 0, -17);
                $UUID         = $row_inner['uuid'];
                $FIRST_NAME   = $row_inner['first_name'];
                $DEFAULT_PASS = $row_inner['default_pass'];
            }

            $stmt->close();

            if ($DEFAULT_PASS == "") {

                die("0<|>Loginlink abgelaufen");

            } else {

                $sql_query = "SELECT * FROM `group_list` WHERE uuid = ?";

                if ($stmt = $mysqli->prepare($sql_query)) {
                    $stmt->bind_param('s', $GUUID);
                    $stmt->execute();
                    $result_inner = $stmt->get_result();

                    while ($row_inner = $result_inner->fetch_assoc()) {
                        $INFO  = $row_inner['info'];
                        $TITLE = $row_inner['title'];
                    }
        
                    $stmt->close();

                    if ($UUID == "bc21d1cf-55f2-4193-935c-eddc7569becc") {
                        $HIDDEN_MESSAGE = "Abibuzzzzz 🥵💦";
                    } else {
                        $HIDDEN_MESSAGE = "";
                    }

                    echo '1';
                    echo '<|>';
                    echo $GUUID;
                    echo '<|>';
                    echo $UUID;
                    echo '<|>';
                    echo $FIRST_NAME;
                    echo '<|>';
                    echo $DEFAULT_PASS;
                    echo '<|>';
                    echo $TITLE;
                    echo '<|>';
                    echo $INFO;
                    echo '<|>';
                    echo $HIDDEN_MESSAGE;

                } else {
                    echo '-1≤|>Vorbereiten des STMT für Tabelle '.$table_name.' fehlgeschlagen.';
                }
            }


        } else {
            echo '-1≤|>Vorbereiten des STMT für Tabelle '.$table_name.' fehlgeschlagen.';
        }
    }

    $result->free();
} else {
    echo '-1≤|>Gruppen durchsuchen fehlgeschlagen. (GUUIDS nicht verfügbar)';

}

$mysqli->close();
?>