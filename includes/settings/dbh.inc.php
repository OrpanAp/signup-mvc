<?php

require_once "config.inc.php";

try {
    // Connect to the MySQL server.
    $pdo = new PDO($dsn, $dbuser, $dbpass);

    // Make PDO throw an exception when a database error occurs.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Check whether the database already exists.
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
    $db_exists = $stmt->fetch();


    // Create the database if it does not exist.
    if (!$db_exists) {
        $pdo->exec("CREATE DATABASE $dbname");
    }


    // Select the database.
    $pdo->exec("USE $dbname");


    // Check and create each table defined in config.inc.php.
    foreach ($tables as $table_name => $table) {

        // Check whether the table already exists.
        $stmt = $pdo->query("SHOW TABLES LIKE '$table_name'");
        $table_exists = $stmt->fetch();


        // Create the table if it does not exist.
        if (!$table_exists) {
            $pdo->exec($table);
        }
    }


    // Release temporary variables.
    $stmt = null;
    $db_exists = null;
    $table_exists = null;


} catch (PDOException $e) {

    // Display the database error.
    die("Connection failed: " . $e->getMessage());
}
