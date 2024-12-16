<?php

include 'header.php';
include 'Includes/User_handler.php';
include 'Includes/Search.php';
include 'Includes/auth.php';

if (isset($_SESSION['message'])) {
    echo "<p style='color: green;'>" . htmlspecialchars($_SESSION['message']) . "</p>";
    unset($_SESSION['message']); // Clear the message after displaying it
}

$userId = $_SESSION['user_id'] ?? null;

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();

            // Don't perform search if the input is empty
            if (query.length === 0) {
                $('#results').empty();
                return;
            }

            $.ajax({
                url: 'search.php', // Your server-side script
                method: 'GET',
                data: {
                    q: query
                },
                success: function(data) {
                    $('#results').html(data); // Update the results div with the response
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                }
            });
        });
    });
</script>

<script type="text/javascript" src="script.js"></script>

<div class="popup-create">
    <div class="popup-content">
        <h3>Create new User</h3>
        <form action="Includes/User_handler.php" method="POST">
            <div class="form-content">
                <p>username</p>
                <input type="text" name="username" required>
                <p>password</p>
                <input type="password" name="password" required>
                <p>email</p>
                <input type="email" name="email" required>

                <label for="Roles">Choose a Role:</label>
                <select name="role" id="Roles" placeholder="Select Role" required>
                    <option value="">Select Role....</option>

                    <!--This code will list all the roles from the database into options-->
                    <?php
                    $role = new User($db);
                    $roleList = $role->roleList();
                    foreach ($roleList as $role) {
                        echo "<option value='" . $role['role_id'] . "'>" . $role['role_name'] . "</option>";
                    }
                    ?>

                </select>
            </div>
            <button type="submit" class="button1" name='submitted'>Add</button>
            <button type="button" class="button4" onclick="closePopup()">cancel</button>
        </form>
    </div>
</div>

<div class="popup-update">
    <div class="popup-content">
        <h3>Edit User</h3>
        <form action="Includes/User_handler.php" method="POST">
            <div class="form-content">
                <?php
                    $userId = $_SESSION['user_id']; // Ensure you validate and sanitize this input
                    $user = new User($db);
                    $userData = $user->getUserById($userId);
                    
                    if (!$userData) {
                        echo "User not found.";
                        exit; // Exit if the user is not found
                    }
                ?>
                <p>Username</p>
                <input type="text" name="edit_username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
                
                <p>Password</p>
                <input type="password" name="password" placeholder="Leave blank to keep current password">
                
                <p>Email</p>
                <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>

                <label for="Roles">Choose a Role:</label>
                <select name="role" id="Roles" required>
                    <option value="">Select Role....</option>

                    <?php
                    $role = new User($db);
                    $roleList = $role->roleList();
                    foreach ($roleList as $role) {
                        // Check if the role is the current user's role
                        $selected = ($role['role_id'] == $userData['role_id']) ? "selected" : "";
                        echo "<option value='" . $role['role_id'] . "' $selected>" . $role['role_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userData['user_id']); ?>">
            <button type="submit" class="button1" name='submitted'>Update</button>
            <button type="button" class="button4" onclick="closePopup()">Cancel</button>
        </form>
    </div>
</div>


<section class="content-head">
    <h1>
        Select subject of your choosing
    </h1>

</section>
<div class="wrapper">
    <div class="container">
        <div class="participants">
            <div class="search-content">
                <input type="text" id="search" placeholder="Search">
                <!-- <div class="results"></div> -->
                <button class="button3">Search</button>
                <button class="button3">Rest All</button>
                <div class="sorting">
                    <button id='add' class="button1">Add User</button>
                </div>
            </div>
            <div class="users-table">
                <table>
                    <?php
                    $user = new User($db);
                    $userList = $user->getUserList(); // Retrieve all users from the database

                    // Check if the user list is not empty
                    if (!empty($userList)) {
                        echo "<table>";
                        echo "<tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Joined Date</th>
                                <th>User Type</th>
                                <th>Action</th>
                            </tr>";

                        // Iterate through the user list and display each user
                        foreach ($userList as $user) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($user["username"]) . "</td>
                                    <td>" . htmlspecialchars($user["email"]) . "</td>
                                    <td>" . htmlspecialchars($user["created_at"]) . "</td>
                                    <td>" . htmlspecialchars($user["role_name"]) . "</td>
                                    <td>
                                        <button id ='update' class='button3'>Edit</button>
                                        <form action='Includes/User_handler.php' method='post' style='display:inline;'>
                                            <input type='hidden' name='user_id' value='" . htmlspecialchars($user["user_id"]) . "' />
                                            <button type='submit' class='button4' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>No results found.</p>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>