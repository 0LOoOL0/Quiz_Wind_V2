<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Quiz_handler.php';

$userId = $_SESSION['user_id'] ?? null;
$userName = $_SESSION['user_id'] ?? null;
$roleId = $_SESSION['role_id'] ?? null;
$roleName = $_SESSION['role_name'] ?? null;

// echo "User ID: " . htmlspecialchars($_SESSION['user_id']) . "<br>";
// echo "Username: " . htmlspecialchars($_SESSION['username']) . "<br>";
// echo "Role ID: " . htmlspecialchars($_SESSION['role_id']) . "<br>";
// echo "Role: " . htmlspecialchars($_SESSION['role_name']) . "<br>";

if ($_SESSION['role_name'] !== 'Teacher') {
    die("Access denied."); // Or redirect to a different page
}
?>


<div class="overlay2">
    <section class="content-head3">
        <h1>
            View Quizzes
        </h1>
    </section>
</div>

<?php
?>

<div class="wrapper">
    <div class="container">
        <section class="content-body">

            <div class="content-quiz">
                <div class="participants">

                    <?php

                    $quiz = new Quiz($db);
                    $quizList = $quiz->getQuizById($userId);

                    if (!empty($quizList)) {
                        foreach ($quizList as $quiz) {
                            echo " <div class='sub-part'>
                        <div class='randomize'>
                            <h3>" . htmlspecialchars($quiz['subject_name']) . "</h>
                            <h1>" . htmlspecialchars($quiz['quiz_title']) . "</h1>
                        </div>
                        <div class='card-content'>
                            <p>" . htmlspecialchars($quiz['quiz_text']) . "</p>
                            <div class='quiz-buttons'>
                            <input type='hidden' name='quiz_id'" . htmlspecialchars($quiz['quiz_id']) . "'/>
                                <button class='button2'><a href='participants_results.php?quiz_id=" . htmlspecialchars($quiz['quiz_id']) . "'>View Participants</a></button>
                            </div>
                        </div>
                    </div>";
                        }
                    }
                    ?>

                    <!-- <div class='sub-part'>
                        <div class='randomize'>
                            <h1>Quiz title</h1>
                        </div>
                        <div class='card-content'>
                            <p>quiz discreption quiz discreption quiz discreption quiz discreption quiz discreption</p>
                            <div class='quiz-buttons'>
                                <button class='button2'><a href='participants_results.php' class='button2'>View Participants</a></button>
                            </div>
                        </div>
                    </div>

                    <div class='sub-part'>
                        <div class="randomize">
                            <h1>Quiz title</h1>
                        </div>
                        <div class="card-content">
                            <p>quiz discreption quiz discreption quiz discreption quiz discreption quiz discreption</p>
                            <div class='quiz-buttons'>
                                <button class='button2'><a href="participants_results.php" class='button2'>View Participants</a></button>
                            </div>
                        </div>
                    </div>
                    <div class='sub-part'>
                        <div class="randomize">
                            <h1>Quiz title</h1>
                        </div>
                        <div class="card-content">
                            <p>quiz discreption quiz discreption quiz discreption quiz discreption quiz discreption</p>
                            <div class='quiz-buttons'>
                                <button class='button2'><a href="participants_results.php" class='button2'>View Participants</a></button>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>

        </section>
    </div>
</div>