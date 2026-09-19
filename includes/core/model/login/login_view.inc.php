<?php

declare(strict_types=1);

function check_login_errors () : array {
    $errors = [];

    if (isset($_SESSION['login_errors'])) {
        $errors = $_SESSION['login_errors'];

        unset($_SESSION['login_errors']);
    }

    return $errors;
}

function check_login_successful () : string {
    $msg = '';

    if (!empty($_SESSION['login_success'])) {
        $msg = $_SESSION['login_success'];

        unset($_SESSION['login_success']);
    }

    return $msg;
}

function login_field_errors(array $field_errors): void
{
    if (!empty($field_errors)) {
        echo '<div class="field-error">';

            foreach ($field_errors as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }


        echo '</div>';
    }
}