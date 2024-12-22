<?php

require_once 'Answer.php'; // Include your Answer class
require_once 'Attempt.php'; // Include your Attempt class

$quizAttemptManager = new Answer($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user ID and quiz ID from the POST data
    $userId = htmlspecialchars($_POST['user_id']);
    $quizId = htmlspecialchars($_POST['quiz_id']);
    
    // Prepare an array to store answers
    $answers = [];

    // Loop through each question's answers
    foreach ($_POST['answers'] as $questionId => $answerData) {
        $selectedOptionId = htmlspecialchars($answerData['selected_option_id']);
        
        // Add to answers array
        $answers[] = [
            'question_id' => $questionId,
            'selected_option_id' => $selectedOptionId,
        ];
    }

    $answer = new Answer($db);
    $totalQuestions = $answer->countQuestionsByQuizId($quizId);

    // If no questions are present, handle accordingly
    if ($totalQuestions > 0) {
        $correctQuestions = $answer->countCorrectOptionsByQuizId($quizId);
        $percentageCorrect = ((double)$correctQuestions / (double)$totalQuestions) * 100;
    } else {
        // If no questions exist, set percentage to 0 or handle as needed
        $percentageCorrect = 0;
    }

    // Determine the attempt number
    $attemptNumber = $quizAttemptManager->calculateAttempts($userId, $quizId) + 1;

    // Save the new attempt
    $quizAttemptManager->saveAttempt($userId, $quizId, $attemptNumber, $percentageCorrect);

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