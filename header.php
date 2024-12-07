<?php
session_start();
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
                <?php if (isset($_SESSION['username'])): ?>
                    <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                    <li><a class='button1' href="main.php">Logout</a></li>
                <?php else: ?>
                    <li><a class='button1' href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
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