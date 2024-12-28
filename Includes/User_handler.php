
<link rel="stylesheet" href="/styles.css">
<?php
require_once 'User.php';
// Display message if it exists
if (isset($_SESSION['message'])) {
    $messageType = $_SESSION['message_type'];
    echo "<div class='alert {$messageType}'>" . htmlspecialchars($_SESSION['message']) . "</div>";
    unset($_SESSION['message']); // Clear the message after displaying
}


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

//register user
if (isset($_POST['register'])) {
    try {
        $user = new User($db);
        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);
        $user->setEmail($_POST['email']);

        // Attempt to register the user
        $newUserId = $user->registerUser();

        // If registration is successful, redirect to the subject page
        if ($newUserId) {
            header("Location: ../login.php");
            exit();
        } else {
            header("Location: ./main.php");
            exit();
        }
    } catch (Exception $ex) {
        // Handle errors (e.g., username or email already exists)
        header("Location: ../main.php?error=" . urlencode($ex->getMessage()));
        exit();
    }
}

//user deleting
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
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

//update password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['saved'])) {
    // Get the email and new password from the form
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];

    try {

        $userManager = new User($db);  
        $result = $userManager->resetPassword($email, $newPassword);
        
        if ($result) {
            echo '<div class="spaceMessage">
            <div class = "denied">
             <h2>Password updated Successfully</h2>
            </div>
        </div>';
            header("Location: ../login.php");
            exit();
        } else {
            echo "Failed to update password.";
        }

       

    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
   
}

//edit users
if (isset($_POST['updateUser'])) {

    $userId = $_GET['user_id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($role)) {
        echo "<div class='alert error'>Please fill in all required fields.</div>";
        // Optionally, you can redirect back to the edit page
        // header("Location: edit_user.php?user_id=" . urlencode($userId));
        // exit();
    } else {
        // Call the updateUser method
        $updateResult = $user->updateUser($userId, $username, $email, $role, $password);

        if ($updateResult === true) {
            echo "<div class='alert success'>User updated successfully.</div>";
            // Redirect or further actions can be added here
        } else {
            echo "<div class='alert error'>Unable to update user: {$updateResult}</div>";
        }
    }
}
