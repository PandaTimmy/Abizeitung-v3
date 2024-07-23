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

// import verify admin
include('verify_admin.php');

function create_admin_account($username, $password, $aa_first_name = "Jane", $aa_last_name = "Doe", $aa_password = null)
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

    if (!verify_admin($username, $password, $mysqli)) {

        // incorrect password
        echo "Falsche Admin zugangsdaten";

    } else {

        // correct password

        if ($aa_password === null) {
            $aa_password = generatePassword();
        }
        
        $aa_uuid = Uuid::uuid4()->toString();
        $aa_hashed_password = password_hash($aa_password, PASSWORD_BCRYPT);
        $aa_username = $aa_first_name . $aa_last_name;


        $incrementCounter = "";
        $foundAvailibleUsername = false;

        // increment username by 1 until an availible username is found
        while (!$foundAvailibleUsername) {

            // check username availability
            $query = "SELECT COUNT(*) AS count FROM admin_users WHERE username = ?";
            $stmt = $mysqli->prepare($query);
            $search_for_username = $aa_username.$incrementCounter;
            $stmt->bind_param("s", $search_for_username);
            $stmt->execute();
            $result = $stmt->get_result();
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
                $aa_username = $aa_username.$incrementCounter;
            }
        }
        $stmt->close();


        // prepared statement
        $stmt = $mysqli->prepare("INSERT INTO `abizeitungsapp`.`admin_users` (
            `username`, 
            `uuid`,
            `first_name`,
            `last_name`,
            `password_hash`
        ) VALUES (?, ?, ?, ?, ?);");

        $stmt->bind_param("sssss",
            $aa_username,
            $aa_uuid,
            $aa_first_name,
            $aa_last_name,
            $aa_hashed_password
        );

        if ($stmt->execute())
        {
            echo "Erfolgreich admin account angelegt.";
            echo "<hr>Passwort des admin accounts: ".$aa_password;
            echo "<br>Benutzername: ".$aa_username;

            // audit log
            $audit_log_date = date("Y-m-d H:i:s");
            $audit_log_aa_uuid = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
            $audit_log_aa_username = $username;
            $audit_log_aa_info = "Created an admin account. Username of new admin account: ".$aa_username." | UUID of new admin account: ". $aa_uuid;
            
            $audit_log_stmt = $mysqli->prepare("INSERT INTO `abizeitungsapp`.`audit_log` (`date`,`admin_account_uuid`,`username`,`info`) VALUES (?, ?, ?, ?);");
            $audit_log_stmt->bind_param("ssss", $audit_log_date, $audit_log_aa_uuid, $audit_log_aa_username, $audit_log_aa_info);
            $audit_log_stmt->execute();
            $audit_log_stmt->close();

        } else {
            // error handling
            echo "Fehler beim anlegen des admin account: " . $stmt->error;
        }

        $stmt->close();
    }
    $mysqli->close();
}

//create_admin_account('TimothyKlimke', 'woxAo2-tysnik-xEprZq-tfs§ik-xGpyXq', 'Timothy', 'Klimke', 'Test Zugangs Passwort');