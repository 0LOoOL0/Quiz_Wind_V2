<?php

require_once 'User.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loginin'])) {

    // Gather form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $db->fetchSingle($stmt);

    // Debugging: Check values
    var_dump($user['password']); // Check the stored hashed password
    var_dump($password); // Check the input password

    // Validate the user
    if ($user && password_verify($password, $user['password'])) {
        // Start a session
        session_start();
        
        // Store user information in session
        $_SESSION['username'] = $user['username'];

        // Redirect to subject_page.php
        header("Location: ../subject_page.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }

}

// with class but not working 
// if (isset($_POST['loginin'])) {

//     $user = new User($db);
//     $error = $user->login($_POST['username'], $_POST['password']);

// }

?>