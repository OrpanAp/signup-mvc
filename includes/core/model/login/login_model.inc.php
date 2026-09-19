<?php

declare(strict_types=1);

function get_username (
    object $pdo,
    string $username
): array|false {
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $query = null;
    $stmt = null;
    
    return $user;
}
