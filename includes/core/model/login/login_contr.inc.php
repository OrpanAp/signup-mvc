<?php

declare(strict_types=1);

function input_errors_defination(
    string $username,
    string $pwd,
): array {

    $errors = [];


    // Check username.
    $username_errors = username_check($username);

    if (!empty($username_errors)) {
        $errors['username'] = $username_errors;
    }

    // Check password.
    $password_errors = password_check($pwd);

    if (!empty($password_errors)) {
        $errors['password'] = $password_errors;
    }


    return $errors;
}


function username_check(string $username): array {

    $errors = [];


    if (empty($username)) {

        $errors[] = "Username is required.";

    } elseif (strlen($username) < 3) {

        $errors[] = "Username must be at least 3 characters.";

    } elseif (strlen($username) > 30) {

        $errors[] = "Username cannot be longer than 30 characters.";
    }


    return $errors;
}

function password_check(
    string $pwd
): array {

    $errors = [];


    if (empty($pwd)) {

        $errors[] = "Password is required.";

    } elseif (strlen($pwd) < 8) {

        $errors[] = "Password must be at least 8 characters.";

    } elseif (!preg_match("/[A-Z]/", $pwd)) {

        $errors[] = "Password must contain at least one uppercase letter.";

    } elseif (!preg_match("/[a-z]/", $pwd)) {

        $errors[] = "Password must contain at least one lowercase letter.";

    } elseif (!preg_match("/[0-9]/", $pwd)) {

        $errors[] = "Password must contain at least one number.";

    } elseif (!preg_match("/[^a-zA-Z0-9]/", $pwd)) {

        $errors[] = "Password must contain at least one special character.";
    }


    return $errors;
}

function is_username_exists(array|false $result): bool
{
    return !empty($result['username']);
}

function is_password_matches(
string $pwd,
string $hashed_pwd
) : bool {
    return password_verify($pwd, $hashed_pwd);
}