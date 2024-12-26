<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'header.php';
include 'Includes/User_handler.php';
include 'Includes/Search.php';
include 'Includes/auth.php';


$user = new User($db);

$userId = $_SESSION['user_id'] ?? null;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Clear the error message after it's displayed
if ($error) {
    unset($_SESSION['error']);
}
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

<!--admin create user-->
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
                <br>
                <br>
                <label for="Roles">Choose a Role:</label>
                <select name="role" id="Roles" placeholder="Select Role" required>
                    <option value="">Select Role....</option>

                    <!--This code will list all the roles from the database into options-->
                    <?php

                    $roleList = $user->roleList();
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
        <h3>Create new User</h3>
        <form action="Includes/edit_user.php" method="POST">
            <div class="form-content">

                <?php
                $userDetail = new User($db);

                $userId = 2;
                $detail = $userDetail->getUserById($userId);

                if (!empty($detail)) {
                    echo '<p>Username</p>
                    <input type="text" name="username" value="' . htmlspecialchars($detail['username']) . '" required>
                    <p>Password</p>
                    <input type="password" name="password" placeholder="">
                    
                    <p>Email</p>
                    <input type="email" name="email" value="' . htmlspecialchars($detail['email']) . '" disabled>

                    <label for="Roles">Choose a Role:</label>
                    <select name="role" id="Roles" disabled>
                    <option value="">Select Role....</option>';

                    // Fetching role list and populating the dropdown
                    $roleList = $user->roleList();
                    foreach ($roleList as $roleItem) {
                        $selected = ($roleItem['role_id'] == $detail['role_id']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($roleItem['role_id']) . "' $selected>" . htmlspecialchars($roleItem['role_name']) . "</option>";
                    }

                    echo '</select>';
                } else {
                    echo '<p>no user</p>';
                }
                ?>
                
            </div>
            <button type="submit" class="button1" name='submitted'>Update</button>
            <button type="button" class="button4" onclick="closePopup()">cancel</button>
        </form>
    </div>
</div>

<div class="overlay2">
    <section class="content-head3">
        <h1>
            Users
        </h1>
    </section>
</div>

<div class="wrapper">
    <div class="container">
        <?php if ($error): ?>
            <div class="error-message" style="color: red;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class='centering'>
            <div class='search-content'>
                <div class='sorting'>
                    <button id='add' class="button2">Add User</button>
                </div>
            </div>
        </div>
        <div class="participants">
            <!-- <div class="search-content">
                <input type="text" id="search" placeholder="Search">

                <button class="button3">Search</button>
                <button class="button3">Rest All</button>
               
            </div> -->

            <div class="users-table">

                <table>
                    <?php

                    $userList = $user->getUserList(); // Retrieve all users from the database

                    if (!empty($userList)) {
                        echo "<table>";
                        echo "<tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Joined Date</th>
                                    <th>User Type</th>
                                    <th style='width:200px'>Action</th>
                                </tr>";

                        foreach ($userList as $user) {
                            echo "<tr>
                                        <td>" . htmlspecialchars($user["username"]) . "</td>
                                        <td>" . htmlspecialchars($user["email"]) . "</td>
                                        <td>" . htmlspecialchars($user["created_at"]) . "</td>
                                        <td>" . htmlspecialchars($user["role_name"]) . "</td>
                                        <td style='display: flex; gap: 10px'>
                                            
                                            <input type='hidden' name='user_id' value='" . htmlspecialchars($user["user_id"]) . "' />
                                            <button class='edit-button button3' data-user-id='" . htmlspecialchars($user["user_id"]) . "'>Edit</button>
                                            
                                            <form action='Includes/User_handler.php' method='post'>
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

                    // <form action='Includes/edit_user.php' method='post'>
                    //     <input type='hidden' name='user_id' value='" . htmlspecialchars($user["user_id"]) . "' />
                    //     <button id='edit' class='button3'><a href='Includes/edit_user.php?user_id=" . htmlspecialchars($user["user_id"]) . "'>Edit</a></button>

                    //     </form>
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>