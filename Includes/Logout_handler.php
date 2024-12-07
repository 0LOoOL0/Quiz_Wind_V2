<?php
session_start();
session_destroy();
header("Includes/Location: login.php"); // Redirect to the login page
exit();
?>