<?php
include 'header.php';
include 'Includes/auth.php';

$quizId = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : null;

if ($quizId === null || $quizId <= 0) {
    die("Invalid quiz ID.");
}
?>

<body class="page10">
<div class="wrapper">
    <div class="container">
        <div class="spaceup">
                <div class="rules">
                    <form>
                        <h2  style='padding-bottom:20px;'>Rule</h2>
                        <p style='padding-bottom:50px;'>Finish the Test in less before times up</p>
                        <a href="quiz_page.php" class="button2">Start</a>
                    </form>
                </div>
        </div>
    </div>
    </div>
</body>
