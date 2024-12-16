<?php

session_start();
include 'Includes/Login_handler.php';
include 'Includes/Logout_handler.php';
include 'Includes/User_handler.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Quiz Wind</title>
</head>

<body>

    <header id="header-scroll">
        <img class="logo" src="Images/logoQuiz.png" alt="quizwind">
        <nav>
            <ul>
                <li><a href="main.php">Home</a></li>
                <li><a href="users_page.php">Users</a></li>
                <li><a href="subject_page.php">Subjects</a></li>
                <li><a href="participant_page.php">Participants</a></li>
                <li><a href="attempt_page.php">My Attempts</a></li>
            </ul>
        </nav>
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <?php if (isset($_SESSION['username'])): ?>
            <p class="userlog">Welcome! <?php echo htmlspecialchars($_SESSION['username']); ?></p>

            <form action="Includes/Logout_handler.php" method="post">
                <button class="button1" name="logout" value="logout">Logout</button>
            </form>
        <?php else: ?>
            <button class='button1'><a href="login.php" style="text-decoration: none; color: inherit;">Login</a></button>
        <?php endif; ?>
    </header>

    <script>
        const header = document.getElementById('header-scroll');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 150) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>