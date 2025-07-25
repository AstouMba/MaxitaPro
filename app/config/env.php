<?php

use Dotenv\Dotenv;

if (!file_exists('../../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
}
// var_dump($_ENV); die;
define("DB_USERNAME", $_ENV["DB_USERNAME"] );
define("DB_PASSWORD", $_ENV["DB_PASSWORD"] );
define("DSN", $_ENV["DSN"] );
// define("TWILIO_SID", $_ENV["TWILIO_SID"]);
// define("TWILIO_TOKEN", $_ENV["TWILIO_TOKEN"]);
// define("TWILIO_FROM", $_ENV["TWILIO_FROM"]);


