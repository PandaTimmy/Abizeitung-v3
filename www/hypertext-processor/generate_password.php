<?php

function generatePassword($length = 12) {
    // Definiere den Zeichensatz, aus dem das Passwort bestehen soll
    $characters = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomPassword = '';

    // Generiere das Passwort
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomPassword;
}

?>