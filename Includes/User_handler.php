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

//user registering
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

//user deleting
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

// if (isset($_POST['register'])) {
    
//     try {
//     $user = new User($db);
//     $user->setUsername($_POST['username']);
//     $user->setPassword($_POST['password']);
//     $user->setEmail($_POST['email']);

//     $newUserId = $user->registerUser();

//     if ($newUserId) {
//         header("Location: ../users_page.php");
//         exit();
//     } else {
//         echo "<p style='color: red;'>Failed creating subject.</p>";
//     }
//     } catch (Exception $ex) {
//         echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
//     }
// }


?>