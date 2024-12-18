<?php
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to main page
    header("Location: main.php");
    exit(); // Stop execution
}
?>