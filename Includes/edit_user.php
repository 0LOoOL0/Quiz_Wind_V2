<?php
// Includes/edit_user.php
header('Content-Type: application/json');

// Include your database connection and User class
require 'User.php';
$user = new User($db);

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate the input
if (isset($data['user_id'], $data['username'], $data['password'])) {
    $userId = $data['user_id'];
    $username = $data['username'];
    $password = $data['password'];

    // Update the user
    if ($user->updateUser($userId, $username, $password)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Unable to update user.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input.']);
}
?>