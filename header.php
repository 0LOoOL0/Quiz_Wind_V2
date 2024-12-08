<?php

session_start();
include 'Includes/Login_handler.php';

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
        <?php if (isset($_SESSION['username'])): ?>
                    <p class="userlog">Welcome! <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    
                    <form action="Include/logout_handler.php" method="post">
                        <a class='button1' href="main.php">Logout</a>
                    </form>

                <?php else: ?>
                    <a class='button1' href="login.php">Login</a>
                <?php endif; ?>
        <!-- <form>
            <a href="login.php" class="button1">Login</a>
        </form> -->
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