<?php

// Add table creation functions here.
// You can create as many tables as needed.

function users_table() {
    return "CREATE TABLE users (
        id INT(11) NOT NULL AUTO_INCREMENT,
        username VARCHAR(30) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        pwd VARCHAR(255) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    )";
}
