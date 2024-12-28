<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Quiz_handler.php';

$quizId = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : null;

?>

<body class="page">
    <div class="wrapper">
        <div class="container">
            <div class="spaceup">
                <div class="rules">
                    <h2 style='padding-bottom:20px;'>Rule</h2>
                    <p style='padding-bottom:50px;'>Finish the quiz before time runs out</p>
                    <a href="quiz_page.php?quiz_id=<?php echo htmlspecialchars($quizId); ?>" class="button2">Start</a>
                </div>
            </div>
        </div>
    </div>
</body>