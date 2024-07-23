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

// import random password generater
include('generate_password.php');


function create_user_account($group_uuid, $cu_first_name = "Jane", $cu_last_name = "Doe")
{

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

    if (false) {

        // incorrect password
        echo "Falsche Admin zugangsdaten";

    } else {

        // correct password

        $cu_password = generatePassword();        
        $cu_uuid = Uuid::uuid4()->toString();
        $cu_hashed_password = password_hash($cu_password, PASSWORD_BCRYPT);
        $cu_username = $cu_first_name . substr($cu_last_name, 0, 3);
        
        $cu_target_table = "group_users_".$group_uuid;
        $cu_target_table = $mysqli->real_escape_string($cu_target_table); // sql injection protection

        // check if target group table exists
        $query = "SHOW TABLES LIKE '$cu_target_table'"; // Achtung: Hier wird der bereinigte Name direkt eingesetzt
        $result = $mysqli->query($query);


        if ($result->num_rows == 0) {

            // table does not exist
            echo "Die Gruppentabelle ”".$cu_target_table."” existiert nicht.";
        } 
        else
        {
            // table exists

            $incrementCounter = "";
            $foundAvailibleUsername = false;

            // increment username by 1 until an availible username is found
            while (!$foundAvailibleUsername) {

                // check username availability
                $query = "SELECT COUNT(*) AS count FROM `" . $cu_target_table . "` WHERE username = ?";
                $checkUsernameSTMT = $mysqli->prepare($query);
                $search_for_username = $cu_username.$incrementCounter;
                $checkUsernameSTMT->bind_param("s", $search_for_username);
                $checkUsernameSTMT->execute();
                $result = $checkUsernameSTMT->get_result();
                $row = $result->fetch_assoc();

                if ($row['count'] > 0) {
                
                    // username taken

                    if ($incrementCounter == "") {
                        $incrementCounter = 2;
                    } else {
                        $incrementCounter++;
                    }
                } else {

                    // username availible

                    $foundAvailibleUsername = true;
                    $cu_username = $cu_username.$incrementCounter;
                }
            }
            $checkUsernameSTMT->close();


            // add user to group list
            $stmt = $mysqli->prepare("INSERT INTO `$cu_target_table` (
                `username`, 
                `uuid`,
                `first_name`,
                `last_name`,
                `password_hash`,
                `admin_permissions`
            ) VALUES (?, ?, ?, ?, ?, 0);");

            $stmt->bind_param("sssss",
                $cu_username,
                $cu_uuid,
                $cu_first_name,
                $cu_last_name,
                $cu_hashed_password
            );

            if ($stmt->execute())
            {
                echo "Erfolgreich user account angelegt.";
                echo "<hr>Passwort des user accounts: ".$cu_password;
                echo "<br>Benutzername: ".$cu_username;

            } else {
                // error handling
                echo "Fehler beim anlegen des user account: " . $stmt->error;
            }

            $stmt->close();
        }


        
    }
    $mysqli->close();
}

create_user_account('7e6c40f9-9206-40f6-9c42-5d5693286765', 'Timothy', 'Klimke');