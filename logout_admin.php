<?php
    // Start session
    session_start();

    // Destroy all session variables
    $_SESSION = array();

    // If a session cookie has been set, delete it
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }

    // Destroy the session
    session_destroy();

    // Redirect the user to the login client page
    header("Location: admin-login");
    exit();
?>