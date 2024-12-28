<?php

require_once 'Answer.php'; // Include your Answer class
require_once 'Attempt.php'; // Include your Attempt class

$quizAttemptManager = new Attempt($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user ID and quiz ID from the POST data
    $userId = htmlspecialchars($_POST['user_id']);
    $quizId = htmlspecialchars($_POST['quiz_id']);
    
    // Prepare an array to store answers
    $answers = [];
    $anySelected = false; // Flag to check if any radio button is selected

    // Loop through each question's answers
    foreach ($_POST['answers'] as $questionId => $answerData) {
        if (!empty($answerData['selected_option_id'])) {
            $selectedOptionId = htmlspecialchars($answerData['selected_option_id']);
            $answers[] = [
                'question_id' => $questionId,
                'selected_option_id' => $selectedOptionId,
            ];
            $anySelected = true; // Mark that an option was selected
        }
    }

    $answer = new Answer($db);
    $totalQuestions = $answer->countQuestionsByQuizId($quizId);

    // Initialize percentageCorrect
    $percentageCorrect = 0;

    // Calculate the percentage only if questions exist
    if ($totalQuestions > 0) {
        if ($anySelected) {
            // Calculate correct ansers only if at lest one option is selcted
            $correctQuestions = $answer->countCorrectOptionsByQuizId($quizId);
            $percentageCorrect = ((double)$correctQuestions / (double)$totalQuestions) * 100;
        }
        // If no options were selected, percentageCorrect remains 0
    }

    //attempts
    //$attemptNumber = $quizAttemptManager->calculateAttempts($userId, $quizId) + 1;

    // Save the new attempt
    //$quizAttemptManager->saveAttempt($userId, $quizId, $attemptNumber, $percentageCorrect);

    // Save the answers using the saveAnswers method
    if ($answer->saveAnswers($userId, $quizId, $answers)) {
        header("Location: ../result_page.php?quiz_id=" . urlencode($quizId));
        exit();
    } else {
        echo "Failed to save answers.";
    }
} else {
    // Handle invalid request method
    echo "Invalid request method.";
}
?>