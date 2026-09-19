<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = $_POST['username'] ?? "";
    $pwd = $_POST['pwd'] ?? "";

    try {
        require_once "../settings/dbh.inc.php";
        require_once "model/login/login_model.inc.php";
        require_once "model/login/login_contr.inc.php";

        // Error handlers
        $errors = input_errors_defination($username, $pwd);

        // Fetch result
        $result = get_username($pdo, $username);

        if (!is_username_exists($result)) {
            $errors['username'][] = "Incorrect login info.";
        }

        if (is_username_exists($result) && !is_password_matches($pwd, $result['pwd'])) {
            $errors['password'][] = "Incorrect password.";
        }

        require_once "../settings/session_regenerate.inc.php";

        if (!empty($errors)) {
            $_SESSION['login_errors'] = $errors;
            $errors = null;
            $_SESSION['form'] = "login";
            header("Location: ../../index.php");
            exit();
        }

        $current_session_id = session_create_id();
        $new_session_id = $current_session_id . "_" . $result['id'];
        session_id($new_session_id);

        $_SESSION['user_id'] = $result['id'];
        $_SESSION['username'] = htmlspecialchars($result['username']);
        $_SESSION["last_regeneration"] = time();


        $_SESSION['form'] = "login";
        $_SESSION['login_success'] = "Login successful.";
        header("Location: ../../index.php");
        exit();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../../index.php");
    die();
}