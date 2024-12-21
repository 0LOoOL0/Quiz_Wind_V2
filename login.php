<?php

include 'header.php';

include 'Includes/User_handler.php';

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Clear the error message after display
?>

<script type="text/javascript" src="script.js"></script>

<div class="popup-create">
    <div class="popup-content">
        <h1>Enter Details</h1>
        <form action="Includes/User_handler.php" method="POST">
            <div class="form-content">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>
            </div>
            <button type="submit" class="button1" name="saved">Save</button>
            <button type="button" class="button4" onclick="closePopup()">Cancel</button>
        </form>
    </div>
</div>

<script type="text/javascript" src="script.js"></script>

<body class="page1">
<div class="spaceup">

        <div class="container">
        <?php if ($error): ?>
            <div class="error-message" style="color: red;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
            <div class="content-login">
                <form action="Includes/login_handler.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <h1>Account Login</h1>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="username" id='username' placeholder="Username" required></td>
                        </tr>
                        <tr>
                            <td><input type="password" name="password" id='password' placeholder="Password" required></td>
                        </tr>
                        <tr>
                            <td>
                                <p>Forgot password? <span id='add'>Click Here!</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td><button class="button2" type="submit" name="loginin" style='margin-top:50px;'>Login</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>
<div class="wrapper">
</div>