<?php

require_once 'User.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loginin'])) {
    // Gather form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create User instance
    $user = new User($db);
    $error = $user->login($username, $password);

    // Display error message if login fails
    if ($error) {
        echo htmlspecialchars($error);
    }
}

// with class but not working 
// if (isset($_POST['loginin'])) {

//     $user = new User($db);
//     $error = $user->login($_POST['username'], $_POST['password']);

// }

?>