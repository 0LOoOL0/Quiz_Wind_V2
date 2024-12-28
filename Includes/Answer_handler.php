<?php

require_once 'Answer.php';
require_once 'attempt.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user ID, quiz ID, and answers from POST request
    $userId = $_POST['user_id'];
    $quizId = $_POST['quiz_id'];
    $answers = $_POST['answers'];

    // Instantiate the AnswerHandler class
    $answerHandler = new Answer($db);
    $attemptHandler = new Attempt($db);

    // Check if answers are provided
    if (!empty($answers)) {
        // Save answers first
        $answerHandler->saveAnswers($userId, $quizId, $answers);
    } else {
        // Optionally handle case where no answers were provided
    }

    // Calculate the percentage of correct answers
    $percentageCorrect = $answerHandler->calculatePercentageCorrectByQuizId($quizId, $userId);

    // Count total attempts to determine attempt number
    $attemptCount = $attemptHandler->countAttempts($userId, $quizId);
    $attemptNumber = $attemptCount + 1;

    // Record the attempt in the database
    $attemptHandler->recordAttempt($userId, $quizId, $attemptNumber, $percentageCorrect);

    // Redirect or provide feedback to the user
    header("Location: ../result_page.php?quiz_id=" . urlencode($quizId) . "&percentage=" . urlencode($percentageCorrect));
    exit();
}
?>