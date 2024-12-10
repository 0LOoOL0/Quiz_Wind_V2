<?php

include 'header.php';
include 'Includes/User_handler.php';
include 'Includes/auth.php';

if (isset($_SESSION['message'])) {
    echo "<p style='color: green;'>" . htmlspecialchars($_SESSION['message']) . "</p>";
    unset($_SESSION['message']); // Clear the message after displaying it
}

?>

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


<section class="content-head">
    <h1>
        Select subject of your choosing
    </h1>

</section>
<div class="wrapper">
    <div class="container">
        <div class="participants">
            <div class="search-content">
                <input type="search" id="search" placeholder="Search">
                <button class="button3">Search</button>
                <button class="button3">Rest All</button>
                <div class="sorting">
                    <button id='add' class="button1">Add User</button>
                </div>
            </div>
            <div class="users-table">
                <table>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Joined date</th>
                        <th>Action</th>
                    </tr>

                    <?php

                    $user = new User($db);
                    $userList = $user->getUserList();

                    //inisiate user object and retreive all users data
                    if (!empty($userList)) {
                        echo "<table>";
                        foreach ($userList as $user) {
                            echo "<tr>
                                <!--<td>" . htmlspecialchars($user["user_id"]) . "</td>-->
                                <td></td>
                                <td>" . htmlspecialchars($user["username"]) . "</td>
                                <td>" . htmlspecialchars($user["email"]) . "</td>
                                <td>" . htmlspecialchars($user["created_at"]) . "</td>
                                <td>
                                    <button class='button3'>Edit</button>
                                    <form action='Includes/User_handler.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='user_id' value='" . htmlspecialchars($user["user_id"]) . "' />
                                        <button type='submit' class='button4' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "0 Results";
                    }


                    ?>
                </table>
            </div>
        </div>
    </div>
</div>