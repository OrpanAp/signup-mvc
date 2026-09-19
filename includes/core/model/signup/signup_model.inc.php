<?php

declare(strict_types=1);

function get_username (
    object $pdo,
    string $username
): array|false {
    $query = "SELECT username FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $query = null;
    $stmt = null;
    
    return $user;
}

function get_email (
    object $pdo,
    string $email
): array|false {
    $query = "SELECT email FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $query = null;
    $stmt = null;
    
    return $user;
}

function set_user(
    object $pdo, 
    string $username, 
    string $email, 
    string $pwd,
    int $pwd_cost
) : void {
    $options =[
        "cost" => $pwd_cost
    ];

    $hashed_pwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $query = "INSERT INTO users (username, email, pwd) VALUES (:username, :email, :pwd)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pwd', $hashed_pwd);
    $stmt->execute();

    $query = null;
    $stmt = null;
    $hash_pwd = null;
    $options = null;
    $pdo = null;
}