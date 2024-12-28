<?php
session_start();
include 'Includes/Login_handler.php';
include 'Includes/Logout_handler.php';
include 'Includes/User_handler.php';

// Get the user's role ID from the session
$roleId = $_SESSION['role_id'] ?? null;
//echo "Role ID: " . htmlspecialchars($_SESSION['role_id']) . "<br>";
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

<?php if (isset($_SESSION['username'])): ?>
    <header id="header-scroll">
        <img class="logo" src="Images/logoQuiz.png" alt="quizwind">
        <nav>
            <ul>
                <!-- <li><a href="main.php">Home</a></li> -->
                <li><a href="subject_page.php">Subjects</a></li>
                <?php if ($roleId == '1'): // Admin role ?>
                    <li><a href="users_page.php">Users</a></li>
                <?php elseif ($roleId == '2'): // Teacher role ?>
                    <li><a href="participant_page.php">Participants</a></li>
                <?php elseif ($roleId == '3'): // Student role ?>
                    <li><a href="attempt_page.php">My Attempts</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <p class="userlog">Welcome! <?php echo htmlspecialchars($_SESSION['username']); ?></p>

        <form action="Includes/Logout_handler.php" method="post">
            <button class="button3" name="logout" value="logout">Logout</button>
        </form>
    </header>
<?php endif; ?>

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
</body>
</html>