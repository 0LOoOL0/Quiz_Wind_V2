<?php

include 'header.php';

include 'Includes/User_handler.php';

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Clear the error message after display
?>

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
                                <p>Forgot password? <a href="login.php">Click Here!</a></p>
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