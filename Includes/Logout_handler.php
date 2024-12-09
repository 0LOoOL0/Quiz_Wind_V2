<?php

// Check if the logout button was pressed
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Optionally, clear the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"], $params["secure"], $params["httponly"]
        );
    }

    // Redirect back to the login page
    header("Location: ../main.php");
    exit();
}
?>