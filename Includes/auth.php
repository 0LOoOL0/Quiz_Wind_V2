<?php
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to main page
    header("Location: login.php");
    exit(); // Stop execution
}
?>