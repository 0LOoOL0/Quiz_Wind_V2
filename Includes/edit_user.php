<?php
// Includes/edit_user.php
header('Content-Type: application/json');

// Include your database connection and User class
require 'User.php';
// $user = new User($db);

// // Get the JSON input
// $data = json_decode(file_get_contents('php://input'), true);

// //Validate the input
// if (isset($data['user_id'], $data['username'], $data['password'])) {
//     $userId = $data['user_id'];
//     $username = $data['username'];
//     $password = $data['password'];

//     // Update the user
//     if ($user->updateUser($userId, $username, $password)) {
//         echo json_encode(['success' => true]);
//     } else {
//         echo json_encode(['success' => false, 'error' => 'Unable to update user.']);
//     }
// } else {
//     echo json_encode(['success' => false, 'error' => 'Invalid input.']);
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updated'])) {
    // Get the user data from the form
    $userId = $_POST['user_id']; // User ID
    $username = $_POST['username']; // New username
    $newPassword = $_POST['new_password']; // New password

    try {
        $userManager = new User($db);
        // Call the method with the correct parameters
        $result = $userManager->changeUserDetail($userId, $username, $newPassword);

        if ($result['success']) {
            // Redirect on success
            header("Location: ../users_page.php");
            exit();
        } else {
            echo "Failed to update user information: " . htmlspecialchars($result['message']);
        }

    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}
?>