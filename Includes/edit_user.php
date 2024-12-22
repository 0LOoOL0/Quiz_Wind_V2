<?php

require_once 'User.php';
$user = new User($db); // Ensure $db is your database connection

// Check if user_id is provided
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    // Debugging output
    var_dump($userId); // This will show the user ID being used
    $userData = $user->getUserById($userId); // Fetch user data

    // Check if user data was found
    if (!$userData) {
        die("User not found."); // Error if no user is found
    }
} else {
    die("No user ID provided."); // Error if no ID is provided
}
?>

<div class="popup-content">
    <h3>Update User</h3>
    <form action="user_handler.php" method="POST">
        <div class="form-content">
            <p>Username</p>
            <input type="text" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
            
            <p>Password</p>
            <input type="password" name="password" placeholder="">
            
            <p>Email</p>
            <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" disabled>

            <label for="Roles">Choose a Role:</label>
            <select name="role" id="Roles" required>
                <option value="">Select Role....</option>
                <?php
                // Fetching role list and populating the dropdown
                $roleList = $user->roleList();
                foreach ($roleList as $roleItem) {
                    $selected = ($roleItem['role_id'] == $userData['role_id']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($roleItem['role_id']) . "' $selected>" . htmlspecialchars($roleItem['role_name']) . "</option>";
                }
                ?>
            </select>

            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userData['user_id']); ?>">
            <button type="submit" class="button1" name="updateUser">Update</button>
        </div>
    </form>
</div>