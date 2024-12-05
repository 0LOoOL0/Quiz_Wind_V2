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
        <img class="logo" src="../Images/logoQuiz.png" alt="quizwind">
        <nav>
            <ul>
                <li><a href="main.php">Home</a></li>
                <li><a href="admin_users_view.php">Users</a></li>
                <li><a href="subject_page.php">Subjects</a></li>
                <li><a href="participants.php">Participants</a></li>
                <li><a href="user_attempt.php">My Attempts</a></li>
            </ul>
        </nav>
        <form>
            <a href="login.php" class="buttons">Login</a>
        </form>
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