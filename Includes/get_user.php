<?php
require_once 'User.php'; // Include your User class

if (isset($_GET['user_id'])) {
    $userId = htmlspecialchars($_GET['user_id']);
    $userDetail = new User($db);
    
    // Fetch user details
    $detail = $userDetail->getUserById($userId);
    
    // Return user details as a JSON response
    if ($detail) {
        echo json_encode($detail);
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}
?>