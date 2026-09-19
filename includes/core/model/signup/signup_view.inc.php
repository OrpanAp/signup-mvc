<?php

declare(strict_types=1);

function check_signup_errors () : array {
    $errors = [];

    if (isset($_SESSION['signup_errors'])) {
        $errors = $_SESSION['signup_errors'];

        unset($_SESSION['signup_errors']);
    }

    return $errors;
}

// function check_signup_form () : string {
//     $active_form = '';

//     if (!empty($_SESSION['form'])) {
//         $active_form = $_SESSION['form'];

//         unset($_SESSION['form']);
//     }

//     return $active_form;
// }

function check_signup_successful () : string {
    $msg = '';

    if (!empty($_SESSION['signup_success'])) {
        $msg = $_SESSION['signup_success'];

        unset($_SESSION['signup_success']);
    }

    return $msg;
}

function set_signup_input_value () : array {
    $value = [];

    if (isset($_SESSION['signup_data'])) {
        $value = $_SESSION['signup_data'];

        unset($_SESSION['signup_data']);
    }

    return $value;
}


function signup_field_errors(array $field_errors): void
{
    if (!empty($field_errors)) {
        echo '<div class="field-error">';

            foreach ($field_errors as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }


        echo '</div>';
    }
}