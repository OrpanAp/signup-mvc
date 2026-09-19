<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = $_POST['username'] ?? "";
    $email = $_POST['email'] ?? "";
    $pwd = $_POST['pwd'] ?? "";
    $confirm_pwd = $_POST['confirm_pwd'] ?? "";


    try {
        require_once "../settings/dbh.inc.php";
        require_once "model/signup/signup_model.inc.php";
        require_once "model/signup/signup_contr.inc.php";

        // Error handlers
        $errors = input_errors_defination($username, $email, $pwd, $confirm_pwd);

        if (is_username_exists($pdo, $username)) {
            $errors['username'][] = "Username already exists.";
        }
        
        if (is_email_exists($pdo, $email)) {
            $errors['email'][] = "Email already exists.";
        }


        require_once "../settings/session_regenerate.inc.php";

        if (!empty($errors)) {
            $_SESSION['signup_errors'] = $errors;
            $errors = null;

            $_SESSION['form'] = "signup";


            // User input data
            $signup_data = [
                'username' => $username,
                'email' => $email
            ];

            $_SESSION['signup_data'] = $signup_data; 
            $signup_data = null;

            header("Location: ../../index.php");
            exit();
        }

        create_user($pdo, $username, $email, $pwd, $pwd_cost);

        $_SESSION['form'] = "signup";
        $_SESSION['signup_success'] = "Signup successful.";
        header("Location: ../../index.php");
        exit();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../../index.php");
    die();
}