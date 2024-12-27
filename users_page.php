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

<!-- Popup Structure -->
<div class="popup-update"  style="display: none;">
    <div class="popup-content">
        <h3>Edit User</h3>
        <form action="Includes/edit_user.php" method="POST" id="edit-user-form">
            <div class="form-content">
                <p>Username</p>
                <input type="text" name="username" id="username" required>
                
                <p>Password</p>
                <input type="password" name="password" placeholder="">
                
                <p>Email</p>
                <input type="email" name="email" id="email" disabled>

                <p>Role</p>
                <input type="text" name="role_name" id="role_name" disabled>
                
            </div>
            <input type="hidden" name="user_id" id="user_id">
            <button type="submit" class="button1" name='submitted'>Update</button>
            <button type="button" class="button4" onclick="closePopup()">Cancel</button>
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
                        echo "<table id='user-table'>";
                        echo "<tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Joined Date</th>
                                    <th>User Type</th>
                                    <th style='width:200px'>Action</th>
                                </tr>";

                        foreach ($userList as $user) {
                            echo "<tr data-user-id='" . htmlspecialchars($user["user_id"]) . "'>
                                        <td class='username'>" . htmlspecialchars($user["username"]) . "</td>
                                        <td class='email'>" . htmlspecialchars($user["email"]) . "</td>
                                        <td class='created_at'>" . htmlspecialchars($user["created_at"]) . "</td>
                                        <td class='role_name'>" . htmlspecialchars($user["role_name"]) . "</td>
                                        <td style='display: flex; gap: 10px'>
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
                    ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const editButtons = document.querySelectorAll('.edit-button');

                            editButtons.forEach(button => {
                                button.addEventListener('click', function() {
                                    const userId = this.getAttribute('data-user-id');
                                    fetch(`Includes/get_user.php?user_id=${userId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data) {
                                                // Populate form fields
                                                document.getElementById('username').value = data.username;
                                                document.getElementById('email').value = data.email;
                                                document.getElementById('user_id').value = data.user_id;

                                                // Set the role in the disabled text input
                                                document.getElementById('role_name').value = data.role_name; // Assuming role_name is returned

                                                // Also set the role ID in the hidden input
                                                document.getElementById('role').value = data.role_id;

                                                // Show popup
                                                document.getElementById('popup-update').style.display = 'flex';
                                            }
                                        })
                                        .catch(error => console.error('Error fetching user details:', error));
                                });
                            });
                        });

                    </script>

                </table>
            </div>
        </div>
    </div>
</div>