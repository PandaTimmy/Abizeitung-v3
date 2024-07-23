<?php
// Datenbankkonfiguration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'abibuzz');

// Secret Keys für JWTy
define('SECRET_KEY', '9a2c98bf63f0b610bb7ccdc759ef53e6fafe24d756b9a16b4ec5babfbd2d4438');
define('REFRESH_SECRET_KEY', '15fd5bad5b7845f83300e232416a39005a6b408eea2010d4d844c16628d76aea');

// Iss und Aud für JWT
define('TOKEN_ISS', 'http://192.168.0.235');
define('TOKEN_AUD', 'http://192.168.0.235');

define('SECURE_COOKIE_BOOL', false);
define('HTTP_ONLY_BOOL', false);

define('DISPLAY_ERRORS_BOOL', false);
?>