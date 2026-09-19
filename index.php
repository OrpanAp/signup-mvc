<?php

require_once "includes/settings/session_regenerate.inc.php";
require_once "includes/core/model/signup/signup_view.inc.php";
require_once "includes/core/model/login/login_view.inc.php";


$signup_errors = check_signup_errors();
$login_errors = check_login_errors();

$active_form = $_SESSION['form'] ?? "login";

$signup_success = check_signup_successful();
$login_success = check_login_successful();
$user_signup_failed_cache_values = set_signup_input_value();


function active_form(
    string $active,
    string $form_id
): string {
    return $active === $form_id ? "active" : "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link rel="stylesheet" href="css/main.css">

    <title>Login / Signup</title>

</head>


<body>


    <div class="container">


        <!-- LOGIN FORM -->

        <form
            class="form <?= active_form($active_form, "login"); ?>"
            id="loginForm"
            action="includes/core/login.inc.php"
            method="post"
        >

            <h2>Login</h2>


            <div class="input-group">

                <label for="loginUsername">
                    Username
                </label>

                <input
                    class="<?= !empty($login_errors['username']) ? 'input-error' : ''; ?>"
                    type="text"
                    id="loginUsername"
                    name="username"
                    placeholder="Enter your username"
                    required
                >

                <?php login_field_errors($login_errors["username"] ?? []); ?>

            </div>


            <div class="input-group">

                <label for="loginPassword">
                    Password
                </label>

                <input
                    class="<?= !empty($login_errors['password']) ? 'input-error' : ''; ?>"
                    type="password"
                    id="loginPassword"
                    name="pwd"
                    placeholder="Enter your password"
                    required
                >

                <?php login_field_errors($login_errors["password"] ?? []); ?>

            </div>


            <button type="submit">
                Login
            </button>


            <div class="toggle">

                Don't have an account?

                <button
                    type="button"
                    id="showSignup"
                >
                    Sign Up
                </button>

            </div>

            <?php if (!empty($login_success)): ?>

                <div class="field-success">

                    <?= $login_success; ?>

                </div>

            <?php endif; ?>

        </form>


        <!-- SIGNUP FORM -->

        <form
            class="form <?= active_form($active_form, "signup"); ?>"
            id="signupForm"
            action="includes/core/signup.inc.php"
            method="post"
        >

            <h2>Sign Up</h2>


            <div class="input-group">

                <label for="signupUsername">
                    Username
                </label>

                <input class="<?= !empty($signup_errors['username']) ? 'input-error' : ''; ?>"
                    type="text"
                    id="signupUsername"
                    name="username"
                    placeholder="Choose a username"
                    required
                    value="<?= htmlspecialchars($user_signup_failed_cache_values['username'] ?? '') ?>"
                >

                <?php signup_field_errors($signup_errors['username'] ?? []); ?>

            </div>


            <div class="input-group">

                <label for="signupEmail">
                    Email
                </label>

                <input class="<?= !empty($signup_errors['email']) ? 'input-error' : ''; ?>"
                    type="email"
                    id="signupEmail"
                    name="email"
                    placeholder="Enter your email"
                    required
                    value="<?= htmlspecialchars($user_signup_failed_cache_values['email'] ?? '') ?>"
                >

                <?php signup_field_errors($signup_errors['email'] ?? []); ?>

            </div>


            <div class="input-group">

                <label for="signupPassword">
                    Password
                </label>

                <input
                class="<?= !empty($signup_errors['password']) ? 'input-error' : ''; ?>"
                    type="password"
                    id="signupPassword"
                    name="pwd"
                    placeholder="Create a password"
                    required
                >

                <?php signup_field_errors($signup_errors['password'] ?? []); ?>

            </div>


            <div class="input-group">

                <label for="signupPasswordConfirm">
                    Confirm Password
                </label>

                <input
                    class="<?= !empty($signup_errors['confirm_password']) ? 'input-error' : ''; ?>"
                    type="password"
                    id="signupPasswordConfirm"
                    name="confirm_pwd"
                    placeholder="Confirm your password"
                    required
                >
            
                <?php signup_field_errors($signup_errors['confirm_password'] ?? []); ?>

            </div>


            <button type="submit">
                Sign Up
            </button>


            <div class="toggle">

                Already have an account?

                <button
                    type="button"
                    id="showLogin"
                >
                    Login
                </button>

            </div>

            <?php if (!empty($signup_success)): ?>

                <div class="field-success">

                    <?= $signup_success; ?>

                </div>

            <?php endif; ?>

        </form>

    </div>


    <script src="js/app.js"></script>

</body>

</html>
