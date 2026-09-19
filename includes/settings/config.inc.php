<?php

$dbhost = "localhost";
$dbname = "user_list";
$dbuser = "root";
$dbpass = "";

$dsn = "mysql:host=$dbhost;charset=utf8mb4";


// Set to true when the website is using HTTPS.
$https_enabled = false;


// Session ID regeneration interval.
// 60 seconds × 30 minutes = 1800 seconds.
$id_regen_interval = 60 * 30;


require_once "tables_create.inc.php";


// Define the tables that should be created.
// The array key is the table name.
// The array value is the function that returns the table's CREATE TABLE SQL.
// Go to => tables_create.inc.php to add logic
$tables = [
    "users" => users_table(),
];



// Password check cost factor
$pwd_cost = 12;