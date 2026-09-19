<?php

// Configure PHP to use cookies for sessions only.
ini_set("session.use_only_cookies", 1);

// Prevent PHP from accepting uninitialized session IDs.
ini_set("session.use_strict_mode", 1);


require_once "config.inc.php";


// Configure the session cookie.
session_set_cookie_params([
    "lifetime" => 0,
    "path" => "/",
    "secure" => $https_enabled,
    "httponly" => true,
    "samesite" => "Lax"
]);


// Start the session.
session_start();



if (isset($_SESSION["user_id"])) {

    // While logged in

    // Check whether a previous session ID regeneration time exists.
    $has_last_regeneration = isset($_SESSION["last_regeneration"]);


    // Regenerate the session ID when no previous regeneration exists.
    $condition_one = !$has_last_regeneration;


    // Regenerate the session ID when the regeneration interval has expired.
    $condition_two = $has_last_regeneration
        && time() - $_SESSION["last_regeneration"] >= $id_regen_interval;


    // Regenerate the session ID if either condition is true.
    if ($condition_one || $condition_two) {
        session_regenerate_id(true);

        $user_id = $_SESSION['user_id'];
        $current_session_id = session_create_id();
        $new_session_id = $current_session_id . "_" . $user_id;

        session_id($new_session_id);

        $_SESSION["last_regeneration"] = time();
    }

} else {

    // Check whether a previous session ID regeneration time exists.
    $has_last_regeneration = isset($_SESSION["last_regeneration"]);


    // Regenerate the session ID when no previous regeneration exists.
    $condition_one = !$has_last_regeneration;


    // Regenerate the session ID when the regeneration interval has expired.
    $condition_two = $has_last_regeneration
        && time() - $_SESSION["last_regeneration"] >= $id_regen_interval;


    // Regenerate the session ID if either condition is true.
    if ($condition_one || $condition_two) {
        session_regenerate_id(true);
        $_SESSION["last_regeneration"] = time();
    }
    
}


