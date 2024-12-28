<?php
require_once 'User.php';


// Check if user_id is set in the POST request
if (isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']); // Ensure it's an integer

    // Create a User object
    $user = new User($db); // Assuming $db is your database connection

    // Set the user ID
    $user->setUserId($userId);

    // Attempt to delete the user
    if ($user->deleteUser()) {
        header("Location: ../users_page.php");
        exit();
    } else {
        echo "Failed to delete user. Please try again.";
    }
} else {
    echo "No user ID provided.";
}
?>