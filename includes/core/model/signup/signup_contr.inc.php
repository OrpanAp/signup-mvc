<?php

declare(strict_types=1);


function input_errors_defination(
    string $username,
    string $email,
    string $pwd,
    string $confirm_pwd
): array {

    $errors = [];


    // Check username.
    $username_errors = username_check($username);

    if (!empty($username_errors)) {
        $errors['username'] = $username_errors;
    }


    // Check email.
    $email_errors = email_check($email);

    if (!empty($email_errors)) {
        $errors['email'] = $email_errors;
    }


    // Check password.
    $password_errors = password_check($pwd);

    if (!empty($password_errors)) {
        $errors['password'] = $password_errors;
    }
    
    // Check confirm password.
    $confirm_password_errors = confirm_password_check($pwd, $confirm_pwd);

    if (!empty($confirm_password_errors)) {
        $errors['confirm_password'] = $confirm_password_errors;
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


function email_check(string $email): array {

    $errors = [];


    if (empty($email)) {

        $errors[] = "Email is required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors[] = "Invalid email.";
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

function confirm_password_check(
    string $pwd,
    string $confirm_pwd
): array {

    $errors = [];

    if (empty($confirm_pwd)) {

        $errors[] = "Confirm password is required.";

    } elseif (!empty($pwd) && $pwd !== $confirm_pwd) {

        $errors[] = "Passwords are not matching.";
    }


    return $errors;
}

function is_username_exists(
    object $pdo, 
    string $username
) : bool {
    return get_username($pdo, $username) !== false;
}

function is_email_exists(
    object $pdo, 
    string $email
) : bool {
    return get_email($pdo, $email) !== false;
}

function create_user(
    object $pdo, 
    string $username, 
    string $email, 
    string $pwd,
    int $pwd_cost
) : void {
    set_user ($pdo, $username, $email, $pwd, $pwd_cost);
}