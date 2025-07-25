<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__  .'/../../');
$dotenv->load();

// define('APP_URL', $_ENV['APP_URL']);
define("DB_USERNAME", $_ENV["DB_USERNAME"]); 
define("DB_PASSWORD", $_ENV["DB_PASSWORD"]);
define("DSN", $_ENV["DSN"]);
// define("TWILIO_SID", $_ENV["TWILIO_SID"]);
// define("TWILIO_TOKEN", $_ENV["TWILIO_TOKEN"]);
// define("TWILIO_FROM", $_ENV["TWILIO_FROM"]);


