<?php
include 'header.php';
include 'Includes/User_handler.php';

// Redirect user if signed in
if (isset($_SESSION['username'])) {
    header("Location: user_logout.php");
    exit();
}

// Retrieve error message from session
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Clear the error message after it's displayed
if ($error) {
    unset($_SESSION['error']);
}
?>


<?php if ($error): ?>
    <div class="error-message" style="color: red;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<div class="main-sections">
    <div class="overlay">
    <section class='back1'>
        <div class="spaceup">
            <div class="hero">
                <h1>Welcome</h1>
                <h4>With Quiz wind you can create quizzes in the most easiest and fastest way possible, then anyone can participate in your quiz and become productive!</h4>
            </div>
        </div>


    </section>
    </div>
    
    <div class="spaceup2">


        <section class='back2'>
            <div class="content-register">
                <form action="Includes/User_handler.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <h1>Create Account</h1>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="username" placeholder="Username" required>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="password" name="password" placeholder="Password" required></td>
                        </tr>
                        <tr>
                            <td><input type="email" name="email" placeholder="Email" required></td>
                        </tr>
                        <tr>
                            <td>
                                <p>&nbsp;Do you have an account? <a href="login.php">Login here!</a></p>
                            </td>
                        </tr>
                        <tr>
                            <td><br><br></td>
                        </tr>
                        <tr>
                            <td><button class="button2" type="submit" name="register">Sign Up</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>