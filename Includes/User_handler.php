<?php

require_once 'User.php'; 

// Admin creating new user

if (isset($_POST['submitted'])) {
    try {
    $user = new User($db);
    $user->setUsername($_POST['username']);
    $user->setPassword($_POST['password']);
    $user->setEmail($_POST['email']);

    if (isset($_POST['role'])) {
        $user->setRoleId($_POST['role']);
    } else {
        throw new Exception("Role ID must be set.");
    }

    $newUserId = $user->createUser();

    if ($newUserId) {
            header("Location: ../users_page.php");
            exit();
    } else {
        echo "<p style='color: red;'>Failed creating user.</p>";
    }
    } catch (Exception $ex) {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
    }

    if (isset($_GET['message'])) {
        echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
    }
}

if (isset($_POST['register'])) {
    try {
        $user = new User($db);

        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);
        $user->setEmail($_POST['email']);
        
        $newUserId = $user->registerUser();

        if ($newUserId) {
            header("Location: ../users_page.php");
            exit();
        } else {
            header("Location: ../main.php");
            exit();
        }
    } catch (Exception $ex) {
        header("Location: main.php?error=" . urlencode($ex->getMessage()));
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']);

    try {
        $user = new User($db);
        $user->setUserId($userId);
        $result = $user->deleteUser();

        if ($result) {
            // $_SESSION['message'] = 'User deleted successfully';
            header("Location: ../users_page.php");
            exit();
        } else {
            echo "Failed to delete user.";
        }
    } catch (Exception $ex) {
        echo "Error: " . htmlspecialchars($ex->getMessage());
    }

    if (isset($_GET['message'])) {
        echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
    }
}

if (isset($_POST['register'])) {
    
    try {
    $user = new User($db);
    $user->setUsername($_POST['username']);
    $user->setPassword($_POST['password']);
    $user->setEmail($_POST['email']);

    $newUserId = $user->registerUser();

    if ($newUserId) {
        header("Location: ../users_page.php");
        exit();
    } else {
        echo "<p style='color: red;'>Failed creating subject.</p>";
    }
    } catch (Exception $ex) {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
    }
}

// if (isset($_POST['loginin'])) {
//     // Get username and password from the form
//     $user = new User($db);
//     $username = trim($_POST['username']);
//     $password = trim($_POST['password']);

//     // Call the login method
//     if ($user->login($username, $password)) {
//         // Redirect to a protected page after successful login
//         header("Location: subject_page.php"); // Change to your desired page
//         exit();
//     } else {
//         // Handle login failure
//         $error = "Invalid username or password.";
//     }
// }


// if (isset($_POST['login'])) {
//     // Check if the username and password are set
//     if (isset($_POST['username']) && isset($_POST['password'])) {
//         // Sanitize user input
//         $username = trim($_POST['username']);
//         $password = trim($_POST['password']);

//         // Set username and password using setters
//         $user->setUsername($username);
//         $user->setPassword($password);

//         // Call the loginUser method
//         if ($user->loginUser()) {
//             // Redirect to a protected page after successful login
//             header("Location: ../subject_page.php");
//             exit();
//         } else {
//             // Handle login failure
//             $error = "Invalid username or password.";
//         }
//     } else {
//         // Handle the case where username or password is not set
//         $error = "Please enter both username and password.";
//     }
// }

?>